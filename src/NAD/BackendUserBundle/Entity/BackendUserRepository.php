<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\BackendUserBundle\Entity;

use NAD\ResourceBundle\Entity\AbstractCollectionRepository;

/**
 * BackendUserRepository
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class BackendUserRepository extends AbstractCollectionRepository
{
    protected $model = 'NADBackendUserBundle:BackendUser';
}
