<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\NavigationBundle\Manager;

use NAD\ResourceBundle\Manager\AbstractNodeManager;

/**
 * Manager for Navigation Menu Nodes
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class NodeManager extends AbstractNodeManager
{

    protected $model = 'NAD\NavigationBundle\Entity\Menu';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {
        /**
         * @var $node \NAD\NavigationBundle\Entity\Menu
         */
        if ($categoryId = $params['parentId']) {
            $nodeParent = $this->em->getRepository($this->model)->find($categoryId);

            if (!($nodeParent)) {
                throw new \LogicException('Nothing found');
            }
        }

        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setParent($nodeParent);
        $node->setLocale($params['locale']);
        $node->setMetaUrl('/');
        $node->setStatus(false);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {
        /**
         * @var $node \NAD\NavigationBundle\Entity\Menu
         */
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setLocale($params['locale']);
        $node->setMetaUrl('/');
        $node->setStatus(false);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

}
