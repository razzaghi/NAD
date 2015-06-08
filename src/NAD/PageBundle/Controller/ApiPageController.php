<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\PageBundle\Controller;

use NAD\ResourceBundle\Controller\Admin\AbstractCollectionController;
use NAD\PageBundle\Entity\Page;

/**
 * ApiPageController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiPageController extends AbstractCollectionController
{

    /**
     * @var string
     */
    protected $model =  "NAD\PageBundle\Entity\Page";

    /**
     * @param string $urlKey
     * @param string $locale
     *
     * @return Page $page
     */
    public function pageViewByURLAction($urlKey, $locale)
    {
        /** @var \NAD\PageBundle\Entity\Page $page */
        $page = $this->container->get("nad.page.manager")->getPageByURL($urlKey, $locale);

        return $page;
    }
}
