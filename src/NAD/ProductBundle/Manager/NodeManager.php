<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ProductBundle\Manager;

use NAD\ResourceBundle\Manager\AbstractNodeManager;
use LogicException;

/**
 * Manager for product categories
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class NodeManager extends AbstractNodeManager
{

    protected $model = 'NAD\ProductBundle\Entity\Category';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {
        if ($categoryId = $params['parentId']) {
            $nodeParent = $this->em->getRepository($this->model)->find($categoryId);

            if (!($nodeParent)) {
                throw new LogicException('Nothing found');
            }
        }

        $url = time();
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setLocale($params['locale']);
        $node->setParent($nodeParent);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($url);

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {
        $url = time();
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setLocale($params['locale']);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($url);

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

}
