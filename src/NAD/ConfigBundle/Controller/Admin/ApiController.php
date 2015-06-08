<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ConfigBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ApiController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * Get config data
     *
     * @return array $config
     */
    public function getAction()
    {
        $config = $this
            ->container
            ->get("nad.config.manager")
            ->getConfig();
        $config['fields'] = $this
            ->container
            ->getParameter('nad_config');

        return $config;
    }

    /**
     * Save config data
     *
     * @param Request $request
     *
     * @return array $config
     */
    public function saveAction(Request $request)
    {
        $settingsData = $request->getContent();
        $this
            ->container
            ->get("nad.config.manager")
            ->saveConfig($settingsData);

        return array('status' => true, 'message' => 'Settings have been saved!');
    }

}
