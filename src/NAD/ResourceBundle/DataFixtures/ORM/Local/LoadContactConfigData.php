<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ResourceBundle\DataFixtures\ORM\Local;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NAD\FixtureBundle\Model\XMLFixture;
use NAD\ConfigBundle\Entity\Config;

/**
 * Config fixtures
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class LoadContactConfigData extends XMLFixture implements OrderedFixtureInterface
{
    protected $fixturesName = array(
        'en/nad_config_contact.xml',
        'ru/nad_config_contact.xml',
        'es/nad_config_contact.xml',
    );

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
                    $config = new Config();
                    $config->setlocale($table->column[1]);
                    $config->setEntity($table->column[2]);
                    $config->setValue($table->column[3]);
                    $manager->persist($config);
                    $manager->flush();
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 20;
    }
}
