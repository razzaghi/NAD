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
use NAD\NavigationBundle\Entity\Menu;

/**
 * Navigation menu fixtures
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class LoadMenuTopData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array(
        'en/nad_menu_top.xml',
        'ru/nad_menu_top.xml',
        'es/nad_menu_top.xml',
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

                foreach ($XML->database->table as $table) {

                    $rootCategory = null;
                    if ($table->column[2] != 'NULL') {
                        $rootCategory = $this->getReference('menu_top_' . $table->column[2]);
                    }
                    $menu = new Menu();
                    $menu->setLocale($table->column[1]);
                    $menu->setTitle($table->column[7]);
                    $menu->setMetaUrl($table->column[8]);
                    $menu->setStatus($table->column[9]);

                    if ($rootCategory) {
                        $menu->setParent($rootCategory);
                    }
                    $manager->persist($menu);
                    $manager->flush();
                    $this->addReference('menu_top_' . $table->column[0], $menu);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 900;
    }
}
