<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ProductBundle\Controller\Admin;

use NAD\ResourceBundle\Controller\Admin\AbstractNodeController;

/**
 * ApiNodeEditController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiNodeEditController extends AbstractNodeController
{

    /**
     * @var string
     */
    protected $model = "NAD\ProductBundle\Entity\Category";

    /**
     * @var string
     */
    protected $nodeManager = "nad.productcategory.node.manager";

}
