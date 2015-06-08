<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\NavigationBundle\Controller;

use NAD\ResourceBundle\Controller\Admin\AbstractNodeController;

/**
 * ApiController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiController extends AbstractNodeController
{

    /**
     * @var string
     */
    protected $model = "NAD\NavigationBundle\Entity\Menu";

}
