<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\NavigationBundle\Controller\Admin;

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
    protected $model = "NAD\NavigationBundle\Entity\Menu";

    /**
     * @var string
     */
    protected $nodeManager = "nad.navigation.node.manager";

}
