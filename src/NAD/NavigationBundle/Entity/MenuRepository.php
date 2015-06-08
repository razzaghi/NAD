<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\NavigationBundle\Entity;

use NAD\ResourceBundle\Entity\AbstractCollectionRepository;

/**
 * Repository for Menu entity
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class MenuRepository extends AbstractCollectionRepository
{

    protected $model = 'NADNavigationBundle:Menu';

}
