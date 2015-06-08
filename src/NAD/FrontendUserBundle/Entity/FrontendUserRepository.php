<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\FrontendUserBundle\Entity;

use NAD\ResourceBundle\Entity\AbstractCollectionRepository;

/**
 * Frontend user repository
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class FrontendUserRepository extends AbstractCollectionRepository
{
    protected $model = 'NADFrontendUserBundle:FrontendUser';

    /**
     * Find user by Username and Email
     *
     * @param string $username
     * @param string $email
     *
     * @return int value
     */
    public function findUser($username, $email)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('COUNT(u.id)')
            ->from($this->model, 'u')
            ->where('u.username = :username')
            ->orWhere('u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $email);

        $r = $qb->getQuery()->getSingleScalarResult();

        return $r;
    }

}
