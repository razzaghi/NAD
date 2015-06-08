<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ResourceBundle\Utility;

/**
 * Password generator
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class PasswordUtility
{

    /**
     * Generate password string
     *
     * @param int $length
     *
     * @return string $password
     */
    public function generatePassword($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);

        return $password;
    }

}
