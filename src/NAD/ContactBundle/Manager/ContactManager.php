<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ContactBundle\Manager;

use Doctrine\ORM\EntityManager;
use Swift_Mailer;
use Symfony\Component\Templating\EngineInterface;

/**
 * ContactManager
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ContactManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $appEmail;

    /**
     * @var EngineInterface
     */
    protected $templating;

    public function __construct(
        EntityManager $em,
        Swift_Mailer $mailer,
        $templating,
        $appEmail
    ) {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->appEmail = $appEmail;
    }

    /**
     * Get Templating service
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * Get Mailer service
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Send email to administration E-mail
     * @param  array $params
     * @return array
     */
    public function sendMail($params)
    {

        try {
            $message = \Swift_Message::newInstance()
                ->setSubject('Contacts Mail')
                ->setFrom($params['email'])
                ->setTo($this->appEmail)
                ->setBody(
                    $this->getTemplating()->render(
                        'NADContactBundle:Default:email.txt.twig',
                        array(
                            'name' => $params['name'],
                            'email' => $params['email'],
                            'phone' => $params['phone'],
                            'message' => $params['message']
                        )
                    )
                );

            $response = $this->getMailer()->send($message);
        } catch (\Swift_TransportException $e) {
            $response = $e->getMessage();
        }

        return $response;
    }

}
