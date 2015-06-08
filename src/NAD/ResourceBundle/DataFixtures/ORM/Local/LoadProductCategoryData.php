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
use NAD\ProductBundle\Entity\Category;

/**
 * Product Categories
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class LoadProductCategoryData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array(
        'en/nad_product_category.xml',
        'ru/nad_product_category.xml',
        'es/nad_product_category.xml',
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
                    $category = new Category();
                    $category->setLocale($table->column[1]);
                    $category->setTitle($table->column[3]);
                    $category->setDescription($table->column[8]);
                    $category->setStatus($table->column[9]);
                    $category->setMetaUrl($table->column[10]);

                    if ($table->column[2] != 'NULL') {
                        $rootCategory = $this->getReference('product_category_' . $table->column[2]);
                        $category->setParent($rootCategory);
                    }
                    $manager->persist($category);
                    $manager->flush();
                    $this->addReference('product_category_' . $table->column[0], $category);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 300;
    }
}
