<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\BackendUserBundle\Manager;

use NAD\BackendUserBundle\Entity\BackendUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Manager for administrator users. Register, Load and others ...
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
     * Constructor
     *
     * @param EntityManager   $entityManager
     * @param EncoderFactory  $encoder
     * @param SecurityContext $securityContext
     */
    public function __construct(
        EntityManager $entityManager,
        EncoderFactory $encoder,
        SecurityContext $securityContext
    ) {
        $this->em = $entityManager;
        $this->encoder = $encoder;
        $this->securityContext = $securityContext;
    }

    protected function getRepository()
    {
        return $this->em->getRepository('NADBackendUserBundle:BackendUser');
    }

    /**
     * Creates User, specially for fixtures
     *
     * @param array $userData
     *
     * @return \NAD\BackendUserBundle\Entity\BackendUser $user
     */
    public function registerFixturesUser(array $userData)
    {
        $user = new BackendUser();
        $user->setEmail($userData['email']);
        $user->setUsername($userData['username']);
        $user->setPlainPassword($userData['password']);
        $user->setEnabled(true);
        $user->setLocked(false);
        $user->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Is user password correct
     *
     * @param BackendUser $user
     * @param string      $password
     *
     * @return boolean $isValid
     */
    public function checkUserPassword(BackendUser $user, $password)
    {
        $encoder = $this->encoder->getEncoder($user);

        if (!$encoder) {
            return false;
        }
        $isValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

        return $isValid;
    }

    /**
     * Is administrator user authenticated
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

                if (in_array('ROLE_ADMIN', $roles)) return true;
            }
        }

        return false;
    }

    /**
     * Loads user by username $username
     *
     * @param array $username
     *
     * @return \NAD\BackendUserBundle\Entity\BackendUser $user
     */
    public function loadUserByUsername($username)
    {
        $user = $this->getRepository()->findOneBy(array('username' => $username));

        return $user;
    }

    /**
     * Loads user by email $email
     *
     * @param array $email
     *
     * @return \NAD\BackendUserBundle\Entity\BackendUser $user
     */
    public function findUserByEmail($email)
    {
        $user = $this->getRepository()->findOneBy(array('email' => $email));

        return $user;
    }

    /**
     * Returns user object by combination of username and email
     *
     * @param array $username
     * @param array $email
     *
     * @return \NAD\BackendUserBundle\Entity\BackendUser $user
     */
    public function findUser($username, $email)
    {
        $user = $this->getRepository()->findUser($username, $email);

        return $user;
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
        return $this->getEntityName() === $class
        || is_subclass_of($class, $this->getEntityName());
    }

}
