<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\OrderBundle\Manager;

use LogicException;
use NAD\FrontendUserBundle\Entity\FrontendUser;
use NAD\OrderBundle\Entity\Order;
use NAD\CartBundle\Manager\CartManager;
use NAD\ConfigBundle\Manager\ConfigManager;
use Doctrine\ORM\EntityManager;

/**
 * OrderManager
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class OrderManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var CartManager
     */
    protected $cartManager;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param ConfigManager $configManager
     * @param CartManager   $cartManager
     */
    public function __construct(
        EntityManager $entityManager,
        ConfigManager $configManager,
        CartManager $cartManager
    ) {
        $this->em = $entityManager;
        $this->settingsManager = $configManager;
        $this->cartManager = $cartManager;
    }

    /**
     * Currency code from the system settings
     *
     * @param string $locale
     *
     * @return string $currency
     */
    private function getCurrencyCode($locale)
    {
        $config = $this
            ->settingsManager
            ->getConfigForEntity($locale, 'general');

        return $config['currency'];
    }

    /**
     * Get single order by given userId and orderId
     *
     * @param FrontendUser $user
     * @param int          $orderId
     *
     * @return Order $orderDetails
     */
    public function getUserOrder(FrontendUser $user, $orderId)
    {
        $order = $this->em
            ->getRepository('NADOrderBundle:Order')
            ->findOrderForUser($user, $orderId);

        return $order;
    }

    /**
     * Get all order for user
     *
     * @param FrontendUser $user
     *
     * @throws LogicException
     *
     * @return Order $orderDetails
     */
    public function getUserOrders(FrontendUser $user)
    {
        if (!($user)) throw new LogicException('User object is missing');

        $orders = $this->em
            ->getRepository('NADOrderBundle:Order')
            ->findAllOrdersForUser($user);

        return $orders;
    }

    /**
     * Create order for given userId
     *
     * @param FrontendUser $user
     * @param mixed        $orderInfo
     *
     * @throws LogicException
     *
     * @return Order $order
     */
    public function createOrderFromCart(FrontendUser $user, $orderInfo)
    {
        if (!($user)) {
            throw new LogicException('User object is missing');
        }

        if (count($user->getCart()) == 0) {
            throw new LogicException('User cart is empty');
        };

        $order = $this->em
            ->getRepository('NADOrderBundle:Order')
            ->createOrderFromCartForUser(
                $user,
                $this->getCurrencyCode($orderInfo['locale']),
                $orderInfo
            );

        return $order;
    }

    /**
     * Create order for user
     *
     * @param FrontendUser $user
     * @param array        $products
     * @param mixed        $orderInfo
     *
     * @throws LogicException
     *
     * @return Order $orderDetails
     */
    public function createOrderFromProducts($user, $products, $orderInfo)
    {
        if (!($user)) {
            throw new LogicException('User object is missing');
        }
        $currencyCode = $this->getCurrencyCode($orderInfo['locale']);

        $order = $this
            ->em
            ->getRepository('NADOrderBundle:Order')
            ->createOrderFromProductsForUser(
                $user,
                $products,
                $currencyCode,
                $orderInfo
            );

        return $order;
    }
}
