<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\SearchBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * SearchManager
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class SearchManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Get list of results
     *
     * @param array $params
     *
     * @return array $return
     */
    public function search($params)
    {
        $pageRepository = $this
            ->em
            ->getRepository('NADPageBundle:Page');

        $total = $pageRepository->getTotalFromRequest($params);
        $collection = $pageRepository->searchFromRequest($params);

        $return = array(
            'total' => $total,
            'collection' => $collection
        );

        return $return;
    }

}
