<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\PageBundle\Controller\Admin;

use NAD\ResourceBundle\Controller\Admin\AbstractCollectionController;

/**
 * PageController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiPageController extends AbstractCollectionController
{
    /**
     * @var string
     */
    protected $model = "NAD\PageBundle\Entity\Page";

}
