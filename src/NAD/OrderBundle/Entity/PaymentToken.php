<?php

namespace NAD\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * PaymentToken
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 *
 * @ORM\Entity(repositoryClass="NAD\OrderBundle\Entity\PaymentTokenRepository")
 * @ORM\Table(name="nad_order_payment_token")
 */
class PaymentToken extends Token
{

}
