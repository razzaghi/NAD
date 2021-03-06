<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ResourceBundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ParamConverter
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ValidationFailedException extends \RuntimeException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $list;

    /**
     * @param ConstraintViolationListInterface $list
     */
    public function __construct(ConstraintViolationListInterface $list)
    {
        parent::__construct(sprintf('Validation failed with %d error(s).', count($list)));

        $this->list = $list;
    }

    public function getConstraintViolationList()
    {
        return $this->list;
    }
}
