<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\FrontendUserBundle\Manager;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use NAD\FrontendUserBundle\Entity\FrontendUser;
use NAD\ResourceBundle\Utility\PasswordUtility;
use LogicException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Templating\EngineInterface;
use Swift_Mailer;

/**
 * Manager for site users.
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class UserManager implements UserProviderInterface
{

    /**
     * @var EncoderFactory
     */
    protected $encoder;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $websiteEmail;

    /**
     * Constructor
     *
     * @param EntityManager   $entityManager
     * @param EncoderFactory  $encoder
     * @param SecurityContext $securityContext
     * @param Swift_Mailer    $mailer
     * @param EngineInterface $templating
     * @param string          $websiteEmail
     */
    public function __construct(
        EntityManager $em,
        EncoderFactory $encoder,
        SecurityContext $securityContext,
        Swift_Mailer $mailer,
        EngineInterface $templating,
        $websiteEmail
    ) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->encoder = $encoder;
        $this->em = $em;
        $this->websiteEmail = $websiteEmail;
        $this->securityContext = $securityContext;
    }

    /**
     * Get User repository
     */
    protected function getRepository()
    {
        return $this->em->getRepository('NADFrontendUserBundle:FrontendUser');
    }

    /**
     * Get current user entity
     *
     * @param int $userId
     *
     * @return \NAD\FrontendUserBundle\Entity\FrontendUser $currentUser
     */
    public function getUser($userId = null)
    {
        if ($userId) return $this->loadById($userId);

        $userToken = $this->securityContext->getToken();
        if ($userToken) {
            $user = $userToken->getUser();

            if ($user !== 'anon.') {
                $roles = $user->getRoles();

                if (in_array('ROLE_USER', $roles)) return $user;
            }
        }

        return false;
    }

    /**
     * Get get session Id
     *
     * @return string $sessionId
     */
    public function getSessionId()
    {
        $sessionId = $this->getSession();

        return $sessionId;
    }

    /**
     * Is site user authenticated
     *
     * @return boolean
     */
    public function isAuthenticated()
    {
        $userToken = $this->securityContext->getToken();

        if ($userToken) {
            $user = $userToken->getUser();

            if ($user !== 'anon.') {
                $roles = $user->getRoles();

                if (in_array('ROLE_USER', $roles)) return true;
            }
        }

        return false;
    }

    /**
     * Is user password correct
     *
     * @param FrontendUser $user
     * @param string       $password
     *
     * @return boolean $isValid
     */
    public function checkUserPassword(FrontendUser $user, $password)
    {
        $encoder = $this->encoder->getEncoder($user);

        if (!$encoder) {
            return false;
        }
        $isValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

        return $isValid;
    }

    /**
     * Creates user, specially for fixtures
     *
     * @param array $userData
     *
     * @return FrontendUser $user
     */
    public function registerFixturesUser(array $userData)
    {
        $user = new FrontendUser();
        $user->setEmail($userData['email']);
        $user->setUsername($userData['username']);
        $user->setPlainPassword($userData['password']);
        $user->setEnabled($userData['enabled']);
        $user->setLocked($userData['locked']);
        $user->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $user->setPhone($userData['phone']);
        $user->setWebsite($userData['website']);
        $user->setFacebook($userData['facebook']);
        $user->setTwitter($userData['twitter']);
        $user->setAbout($userData['about']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Update User details
     *
     * @param array $userData
     *
     * @return string $message
     */
    public function updateDetailsCurrentUser(array $userData)
    {
        try {
            $user = $this->securityContext->getToken()->getUser();

            if ($userData['phone']) $user->setPhone($userData['phone']);
            if ($userData['website']) $user->setWebsite($userData['website']);
            if ($userData['about']) $user->setAbout($userData['about']);

            if ($userData['facebook']) $user->setFacebook($userData['facebook']);
            if ($userData['twitter']) $user->setTwitter($userData['twitter']);

            $this->em->persist($user);
            $this->em->flush();
            $message = 'Information successfully updated!';
        } catch (\Swift_TransportException $e) {
            $message = $e->getMessage();
        }

        return $message;
    }

    /**
     *   Register user and send userinfo by email
     */
    public function registerUser(array $userData)
    {
        $user = $this->loadUserByUsername($userData['username']);

        if (!$user) {
            $user = new FrontendUser();
            $encoder = $this->encoder->getEncoder($user);
            $encodedPassword = $encoder->encodePassword($userData['password'], $user->getSalt());

            $user->setEmail($userData['email']);
            $user->setUsername($userData['username']);
            $user->setPassword($encodedPassword);
            $user->setEnabled(true);
            $user->setLocked(false);

            $user->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));

            $this->em->persist($user);
            $this->em->flush();

            // Send user info via email
            try {
                $message = \Swift_Message::newInstance()
                    ->setSubject('New Account!')
                    ->setFrom($this->websiteEmail)
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->templating->render(
                            'NADFrontendUserBundle:Email:registration.txt.twig',
                            array(
                                'username' => $user->getUsername(),
                                'password' => $userData['password'],
                                'email' => $user->getEmail(),
                            )
                        )
                    );

                $this->mailer->send($message);
            } catch (\Swift_TransportException $e) {
            }

            return $user;

        } else {
            return false;
        }

    }

    /**
     *   Reset and send password by email
     */
    public function resetPassword($user)
    {
        if ($user) {
            $utility = new PasswordUtility();
            $password = $utility->generatePassword();
            $encoder = $this->encoder->getEncoder($user);
            $encodedPassword = $encoder->encodePassword($password, $user->getSalt());
            $user->setPassword($encodedPassword);

            // Send password via email
            try {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Password reset')
                    ->setFrom($this->websiteEmail)
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->templating->render(
                            'NADFrontendUserBundle:Email:newPassword.txt.twig',
                            array(
                                'username' => $user->getUsername(),
                                'password' => $password,
                            )
                        )
                    );
                $response = $this->mailer->send($message);
            } catch (\Swift_TransportException $e) {
                $response = $e->getMessage();
            }
            $this->em->persist($user);
            $this->em->flush();

            return $response;
        } else {
            return false;
        }
    }

    public function loadUserByUsername($username)
    {
        $user = $this->getRepository()->findOneBy(array('username' => $username));

        return $user;
    }

    public function loadById($id)
    {
        $user = $this->getRepository()->findOneBy(array('id' => $id));

        if (!($user)) {
            throw new LogicException('User not found');
        }

        return $user;
    }

    public function findUserByEmail($email)
    {
        $user = $this->getRepository()->findOneBy(array('email' => $email));

        if (!($user)) {
            throw new LogicException('User not found');
        }

        return $user;
    }

    /**
     * @param $username
     * @param $email
     *
     * @return UserInterface
     */
    public function findUser($username, $email)
    {
        return $this->em->getRepository('NADFrontendUserBundle:FrontendUser')->findUser($username, $email);
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        $name = 'NAD\FrontendUserBundle\Entity\FrontendUser';

        return $name === $class || is_subclass_of($class, $name);
    }

}
