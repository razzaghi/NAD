<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ContactBundle\Controller;

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
     * sendMessageAction
     *
     * @param Request $request
     *
     * @return array $status;
     */
    public function sendMessageAction(Request $request)
    {
        $params = json_decode($request->getContent(),true);

        if ($params['name'] && $params['email'] && $params['phone'] && $params['message']) {
            $response = $this->container->get("nad.contact.manager")->sendMail($params);

            if ($response == 1) {
                $status = array('status' => true, 'message' => 'Your message has been sent!');
            } else {
                $status = array('status' => false, 'message' => $response);
            }
        } else {
            $status = array('status' => false, 'message' => 'Empty params in your request');
        }

        return $status;
    }

}
