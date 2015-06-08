<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\NAD\AddressingBundle\Entity;

use PhpSpec\ObjectBehavior;

/**
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class AddressSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NAD\AddressingBundle\Entity\Address');
    }

    public function it_should_not_have_id()
    {
        $this->getId()->shouldReturn(null);
    }

}
