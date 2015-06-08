<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\OrderBundle\Manager;

use LogicException;
use NAD\OrderBundle\Entity\Invoice;
use Doctrine\ORM\EntityManager;
use NAD\OrderBundle\Entity\Order;

/**
 * InvoiceManager
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class InvoiceManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * Get single invoice by Id
     *
     * @param int $id
     *
     * @return \NAD\OrderBundle\Entity\Order $orderDetails
     *
     * @throws LogicException
     */
    public function getInvoice($id)
    {
        $invoice = $this->em->getRepository('NADOrderBundle:Invoice')->find($id);

        if (!($invoice)) {
            throw new LogicException('Nothing found');
        }

        return $invoice;
    }

    /**
     * Create invoice for order Id
     *
     * @param Order $order
     *
     * @return Invoice $invoice|false
     *
     */
    public function createInvoiceForOrder(Order $order)
    {
        if ($order) {

            if (!$order->getInvoice()) {
                $invoice = new Invoice();
                $invoice->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $invoice->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $this->em->persist($invoice);
                $this->em->flush();
                // Update order data
                $order->setInvoice($invoice);
                $this->em->persist($order);
                $this->em->flush();

                return $invoice;
            }
        }

        return false;
    }

}
