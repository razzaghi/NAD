<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ProductBundle\Manager;

use NAD\ResourceBundle\Utility\UrlUtility;
use LogicException;
use Doctrine\ORM\EntityManager;

/**
 * Manager for Products, mostly used in REST API
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ProductManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Get single detailed product with category by URLKey
     *
     * @param string $urlKey
     *
     * @return \NAD\ProductBundle\Entity\Product $product
     *
     * @throws LogicException
     */
    public function getProductByURL($urlKey)
    {
        $product = $this->em->getRepository('NADProductBundle:Product')->findOneBy(array('metaUrl' => $urlKey));

        if (!($product)) {
            throw new LogicException('Nothing found');
        }

        return $product;
    }

    /**
     * validate metaUrl for Product Entity and return one we can use
     *
     * @param string $url
     *
     * @param int $productId
     *
     * @return string $validUrl
     */
    public function normalizeProductUrl($url, $productId = null)
    {
        $product = $this->em->getRepository('NADProductBundle:Product')->findTotalByURL($url, $productId);
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        if ($product) {
            $validUrl = $validUrl . '-' . time();
        }

        return $validUrl;
    }

    /**
     * Get List of all products, except disabled
     * @return string
     */
    public function getEnabledProducts()
    {
        $productList = $this->em->getRepository('NADProductBundle:Product')->getEnabledProducts();

        return $productList;
    }

    /**
     * load product object by productId
     *
     * @param integer $productId
     *
     * @return \NAD\ProductBundle\Entity\Product $product
     *
     * @throws LogicException
     */
    public function loadById($productId)
    {
        $product = $this->em->getRepository('NADProductBundle:Product')->findOneBy(array('id' => $productId));

        if (!($product)) {
            throw new LogicException('Nothing found');
        }

        return $product;
    }

}
