<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\AddressingBundle\Controller;

use NAD\ResourceBundle\Controller\Admin\AbstractCollectionController;

/**
 * ApiCountryController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiCountryController extends AbstractCollectionController
{

    /**
     * @var string
     */
    protected $model = "NAD\AddressingBundle\Entity\Country";

}
