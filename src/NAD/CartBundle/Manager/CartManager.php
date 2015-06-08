<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\CartBundle\Manager;

use LogicException;
use Doctrine\ORM\EntityManager;
use NAD\FrontendUserBundle\Manager\UserManager;
use NAD\ProductBundle\Manager\ProductManager;
use NAD\FrontendUserBundle\Entity\FrontendUser;
use NAD\CartBundle\Entity\Cart;

/**
 * Manager for Cart, mostly used in REST API
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class CartManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var ProductManager
     */
    protected $productManager;

    /**
     * Constructor
     *
     * @param EntityManager  $entityManager
     * @param UserManager    $frontendUserManager
     * @param ProductManager $productManager
     */
    public function __construct(
        EntityManager $entityManager,
        UserManager $frontendUserManager,
        ProductManager $productManager
    )
    {
        $this->em = $entityManager;
        $this->userManager = $frontendUserManager;
        $this->productManager = $productManager;
    }

    /**
     * Get get cart products for given $userId
     *
     * @param FrontendUser $user
     *
     * @return Cart $cartItems
     */
    public function getUserCart($user)
    {
        $cartItems = $this->em->getRepository('NADCartBundle:Cart')->findBy(array('frontenduser' => $user));

        return $cartItems;
    }

    /**
     * Adds product to cart by given $id and $qty
     *
     * @param FrontendUser $user
     * @param int          $productId
     * @param int          $qty
     *
     * @return Cart $cartItem
     *
     * @throws LogicException
     */
    public function addProductToCart($user, $productId, $qty = 1)
    {
        if (!($user)) throw new LogicException('User object is missing');

        $product = $this->productManager->loadById($productId);
        $cartItem = $this->em->getRepository('NADCartBundle:Cart')->addProduct($user, $product, $qty);

        return $cartItem;
    }

    /**
     * Updates product item inside cart by given $id and $qty
     *
     * @param FrontendUser $user
     * @param int          $productId
     * @param int          $qty
     *
     * @return Cart $cartItem
     *
     * @throws LogicException
     */
    public function updateProductInCart($user, $productId, $qty = null)
    {
        if (!($user)) throw new LogicException('User object is missing');

        $product = $this->productManager->loadById($productId);
        $cartItem = $this->em->getRepository('NADCartBundle:Cart')->updateProduct($user, $product, $qty);

        return $cartItem;
    }

}
