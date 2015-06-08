<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\FrontendUserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * FrontendUser
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="NAD\FrontendUserBundle\Entity\FrontendUserRepository")
 * @ORM\Table(name="nad_user_frontend")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @JMS\ExclusionPolicy("none")
 */
class FrontendUser implements AdvancedUserInterface//, \Serializable
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Email
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Exclude
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Exclude
     */
    private $salt;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Type("boolean")
     */
    private $enabled = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Type("boolean")
     */
    private $locked = false;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     * @JMS\Type("DateTime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Type("DateTime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @JMS\Type("DateTime")
     */
    private $lastLogin;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     */
    private $expiresAt;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     * @JMS\Type("string")
     */
    protected $plainPassword;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="NAD\CartBundle\Entity\Cart", mappedBy="frontenduser")
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<NAD\CartBundle\Entity\Cart>")
     */
    private $cart;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="NAD\OrderBundle\Entity\Order", mappedBy="frontenduser")
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<NAD\OrderBundle\Entity\Order>")
     */
    private $orders;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="NAD\AddressingBundle\Entity\Address", mappedBy="frontenduser", cascade={"remove"})
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<NAD\AddressingBundle\Entity\Address>")
     */
    private $addresses;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $about;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Assert\Type(type="string")
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    private $website;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    private $facebook;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    private $twitter;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->cart = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * @param  string $password
     * @return $this
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set lastLogin
     *
     * @param  \DateTime    $lastLogin
     * @return FrontendUser
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set expiresAt
     *
     * @param  \DateTime    $expiresAt
     * @return FrontendUser
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set enabled
     *
     * @param  boolean      $enabled
     * @return FrontendUser
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set locked
     *
     * @param  boolean      $locked
     * @return FrontendUser
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set username
     *
     * @param  string       $username
     * @return FrontendUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param  string       $password
     * @return FrontendUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param  string       $email
     * @return FrontendUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * Set salt
     *
     * @param  string       $salt
     * @return FrontendUser
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set phone
     *
     * @param  string       $phone
     * @return FrontendUser
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set website
     *
     * @param  string       $website
     * @return FrontendUser
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set facebook
     *
     * @param  string       $facebook
     * @return FrontendUser
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param  string       $twitter
     * @return FrontendUser
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set about
     *
     * @param  string       $about
     * @return FrontendUser
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Add addresses
     *
     * @param  \NAD\AddressingBundle\Entity\Address $addresses
     * @return FrontendUser
     */
    public function addAddress(\NAD\AddressingBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \NAD\AddressingBundle\Entity\Address $addresses
     */
    public function removeAddress(\NAD\AddressingBundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add orders
     *
     * @param  \NAD\OrderBundle\Entity\Order $orders
     * @return FrontendUser
     */
    public function addOrder(\NAD\OrderBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \NAD\OrderBundle\Entity\Order $orders
     */
    public function removeOrder(\NAD\OrderBundle\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add cart
     *
     * @param  \NAD\CartBundle\Entity\Cart $cart
     * @return FrontendUser
     */
    public function addCart(\NAD\CartBundle\Entity\Cart $cart)
    {
        $this->cart[] = $cart;

        return $this;
    }

    /**
     * Remove cart
     *
     * @param \NAD\CartBundle\Entity\Cart $cart
     */
    public function removeCart(\NAD\CartBundle\Entity\Cart $cart)
    {
        $this->cart->removeElement($cart);
    }

    /**
     * Get cart
     *
     * @return Collection
     */
    public function getCart()
    {
        return $this->cart;
    }
}
