<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\PageBundle\Manager;

use NAD\ResourceBundle\Manager\AbstractNodeManager;
use LogicException;

/**
 * Manager for page categories
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class NodeManager extends AbstractNodeManager
{

    protected $model = 'NAD\PageBundle\Entity\Category';

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

        $node = new $this->model();
        $node->setlocale($params['locale']);
        $node->setTitle($params['name']);
        $node->setParent($nodeParent);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl('/');
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {
        $node = new $this->model();
        $node->setlocale($params['locale']);
        $node->setTitle($params['name']);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl('/');
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

}
