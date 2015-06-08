<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ProductBundle\Controller;

use NAD\ResourceBundle\Controller\Admin\AbstractCollectionController;

/**
 * Frontend Product REST API controller
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiProductController extends AbstractCollectionController
{

    /**
     * @var string
     */
    protected $model = "NAD\ProductBundle\Entity\Product";

    /**
     * @param string $urlKey
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $product
     */
    public function productViewByURLAction($urlKey)
    {
        /** @var \NAD\ProductBundle\Entity\Product $product */
        $product = $this->container->get("nad.product.manager")->getProductByURL($urlKey);

        return $product;
    }
}
