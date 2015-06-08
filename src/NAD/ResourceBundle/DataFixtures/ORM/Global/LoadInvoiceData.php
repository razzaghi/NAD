<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ResourceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NAD\FixtureBundle\Model\XMLFixture;

/**
 * Order fixtures
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class LoadInvoiceData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/nad_invoice.xml');

    /**
     * Invoice manager
     * @return \NAD\OrderBundle\Manager\InvoiceManager
     */
    protected function getInvoiceManager()
    {
        return $this->container->get('nad.invoice.manager');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);

                foreach ($XML->database->table as $table) {
                    $order = $this->getReference('order_' . $table->column[1]);
                    $invoice = $this->getInvoiceManager()->createInvoiceForOrder($order);
                    $this->addReference('invoice_' . $table->column[0], $invoice);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 420;
    }
}
