<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ConfigBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception;

/**
 * Config Repository
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ConfigRepository extends EntityRepository
{

    /**
     * Returns all stored settings
     *
     * @param string $locale
     *
     * @return array $collection
     */
    public function getAllSettings($locale)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('c.entity, c.value, c.locale')
            ->from('NADConfigBundle:Config', 'c');

        if ($locale) {
            $query->andWhere('c.locale = :locale')->setParameter('locale', $locale);
        }
        $collection = $query->getQuery()->execute();

        return $collection;
    }

    /**
     * Get config data for current entity & locale
     *
     * @param string $locale
     * @param string $entityName
     *
     * @return array $entity
     */
    public function getConfig($locale, $entityName)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $entity = $qb->select('c')
            ->from('NADConfigBundle:Config', 'c')
            ->where('c.locale = :locale')->setParameter('locale', $locale)
            ->andWhere('c.entity = :entity')->setParameter('entity', $entityName)
            ->getQuery()
            ->getOneOrNullResult();

        return $entity;
    }

    /**
     * saveConfig
     *
     * @param array $settings
     */
    public function saveConfig($settings)
    {
        foreach ($settings as $locale => $entities) {
            foreach ($entities as $entity => $value) {
                $this->setConfig($locale, $entity, $value);
            }
        }
    }

    /**
     * Set config data for current entity & locale
     *
     * @param string $locale
     * @param string $entity
     * @param string $value
     *
     * @throws \RuntimeException
     */
    public function setConfig($locale, $entity, $value)
    {
        $config = $this->getConfig($locale, $entity);

        if (!$config) {
            $config = new Config();
        }

        try {
            $config->setlocale($locale);
            $config->setEntity($entity);
            $config->setValue(json_encode($value));
            $this->_em->persist($config);
            $this->_em->flush();
        } catch (Exception $e) {
            throw new \RuntimeException($e);
        }
    }
}
