<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * ApiController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * searchAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function searchAction(Request $request)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'query' => $request->get('query'),
            'order' => $request->get('order'),
            'orderby' => $request->get('orderby'),
            'locale' => $request->get('locale')
        );

        if (!$params['query']) {
            return false;
        };
        $searchManager = $this
            ->container
            ->get("nad.search.manager");

        return $searchManager->search($params);
    }

}
