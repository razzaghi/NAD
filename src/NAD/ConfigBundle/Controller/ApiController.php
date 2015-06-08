<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ApiController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * Config for site
     *
     * @param string $locale
     *
     * @return array $config
     */
    public function getAction($locale)
    {
        $config = $this
            ->container
            ->get("nad.config.manager")
            ->getConfig($locale);

        return $config;
    }

}
