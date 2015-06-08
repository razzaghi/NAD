<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\PageBundle\Entity;

use NAD\ResourceBundle\Entity\AbstractCollectionRepository;

/**
 * PageRepository
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class PageRepository extends AbstractCollectionRepository
{

    protected $model = 'NADPageBundle:Page';

    /**
     * Get pages based on limit, current pagination and search query
     * @param  array                         $params
     * @return \NAD\PageBundle\Entity\Page
     */
    public function searchFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $pages = $query->select('p')
            ->from($this->model, 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale)
            ->andWhere('p.status = 1')
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('p.' . $this->pageOrder, $this->pageOrderBy)
            ->getQuery()
            ->execute();

        return $pages;
    }

    /**
     * Get pages based on limit, current pagination and search query
     * @return \NAD\PageBundle\Entity\Page $pages
     */
    public function getEnabledPages()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $pages = $query->select('p')
            ->from($this->model, 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $pages;
    }

    /**
     * Get pages filtered by category
     *
     * @param int $categoryId
     *
     * @return \NAD\PageBundle\Entity\Page $pages
     */
    public function getPagesByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $pages = $query->select('p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt')
            ->from($this->model, 'p')
            ->innerJoin('p.categories', 'c')
            ->where('p.status = 1')
            ->andWhere('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->execute();

        return $pages;
    }

    /**
     * Find pages by URL
     *
     * @param string $url
     * @param int    $pageId
     *
     * @return int $found
     */
    public function findTotalByURL($url, $pageId = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('COUNT(p.id)')
            ->from($this->model, 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($pageId) {
            $query->andWhere('p.id != :pageId')->setParameter('pageId', $pageId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

}
