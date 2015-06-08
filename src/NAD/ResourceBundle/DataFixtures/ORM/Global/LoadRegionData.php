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
use NAD\AddressingBundle\Entity\Region;

/**
 * Region fixtures
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class LoadRegionData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/nad_region.xml');

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);
                $region = null;

                foreach ($XML->database->table as $table) {
                    $country = $this->getReference('country_' . $table->column[4]); // Spain

                    $region = new Region();
                    $region->setName($table->column[1]);
                    $region->setCountry($country);
                    $manager->persist($region);
                    $manager->flush();
                }
                $this->addReference('region_' . $table->column[0], $region);
            }
        }

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 520;
    }
}
