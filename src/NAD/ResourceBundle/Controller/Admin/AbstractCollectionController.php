<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ResourceBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class AbstractCollectionController
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class AbstractCollectionController extends Controller
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * @param Request $request
     *
     * @return null|mixed $entity
     */
    protected function getEntityFromRequest(Request $request)
    {
        $configuration = new ParamConverter(array(
            'class' => $this->model
        ));
        $entity = $this->get('api_param_converter')->execute($request, $configuration);

        return $entity;
    }

    /**
     * @param $entity
     * @param null $id
     *
     * @return Response
     */
    protected function processEntity($entity, $id = null)
    {
        if ($id) {
            $statusCode = 204;
        } else {
            $statusCode = (null === $entity->getId()) ? 201 : 204;
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        $response = new Response();
        $response->setStatusCode($statusCode);

        // set the `Location` header only when creating new resources
        if (201 === $statusCode) {
            $route = str_replace(
                "_post",
                '_get',
                $this->container->get('request')->get('_route')
            );
            $response->headers->set(
                'Location',
                $this->generateUrl(
                    $route,
                    array('id' => $entity->getId()),
                    true // absolute
                )
            );
        }

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function putAction(Request $request)
    {
        $entity = $this->getEntityFromRequest($request);
        $this->processEntity($entity);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function postAction(Request $request)
    {
        $entity = $this->getEntityFromRequest($request);

        return $this->processEntity($entity);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getAction(Request $request)
    {
        return $this->getEntityFromRequest($request);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function deleteAction(Request $request)
    {
        $entity = $this->getEntityFromRequest($request);

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getCollectionAction(Request $request)
    {
        $params = array(
            'locale' => $request->get('locale'),
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category'),
            'filter' => $request->get('filter')
        );

        /**
         * @var $repo \NAD\ResourceBundle\Entity\AbstractCollectionRepository
         */
        $repo = $this
            ->getEntityManager()
            ->getRepository($this->model);
        $total = $repo->getTotalFromRequest($params);
        $collection = $repo->getCollectionFromRequest($params);

        return array(
            'total' => $total,
            'collection' => $collection
        );
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getNodeCollectionAction(Request $request)
    {
        $params = array(
            'locale' => $request->get('locale'),
        );

        /**
         * @var $repo \NAD\ResourceBundle\Entity\AbstractCollectionRepository
         */
        $repo = $this
            ->getEntityManager()
            ->getRepository($this->model);
        $collection = $repo->getCollectionFromRequest($params);

        return $collection;
    }

}
