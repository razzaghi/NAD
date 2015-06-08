<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\BackendUserBundle\Controller\Admin;

use NAD\ResourceBundle\Controller\Admin\AbstractCollectionController;

/**
 * ApiController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiController extends AbstractCollectionController
{

    /**
     * @var string
     */
    protected $model = "NAD\BackendUserBundle\Entity\BackendUser";

}
