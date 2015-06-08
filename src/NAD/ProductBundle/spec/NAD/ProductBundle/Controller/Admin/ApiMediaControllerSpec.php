<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\NAD\ProductBundle\Controller\Admin;

use PhpSpec\ObjectBehavior;

/**
 * ApiMediaControllerSpec
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiMediaControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('\NAD\ProductBundle\Controller\Admin\ApiMediaController');
    }

}
