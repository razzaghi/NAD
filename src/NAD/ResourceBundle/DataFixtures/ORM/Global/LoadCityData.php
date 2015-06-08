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
use NAD\AddressingBundle\Entity\City;

/**
 * City fixtures
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class LoadCityData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/nad_city.xml');

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);
                $city = null;

                foreach ($XML->database->table as $table) {
                    $country = $this->getReference('country_' . $table->column[4]); // Spain
                    $region = $this->getReference('region_' . $table->column[5]); // City of Madrid

                    $city = new City();
                    $city->setName($table->column[1]);
                    $city->setRegion($region);
                    $city->setCountry($country);
                    $manager->persist($city);
                    $manager->flush();
                }
                $this->addReference('city_' . $table->column[0], $city);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 530;
    }
}
