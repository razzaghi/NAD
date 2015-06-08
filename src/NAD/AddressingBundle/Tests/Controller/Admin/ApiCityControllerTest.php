<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\AddressingBundle\Tests\Controller\Admin;

use NAD\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiCityControllerTest
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiCityControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetCitiesAction()
    {
        $this->client->request(
            'GET',
            '/administrator/api/addressing/city/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);
    }

    public function testPostCityAction()
    {
        $country = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Country')
            ->findOneBy(['iso2' => 'ES']);
        $region = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Region')
            ->findOneBy(['name' => 'Comunidad de Madrid']);

        $data = array(
            'name' => 'Alicante',
            'country' => array('id' => $country->getId()),
            'region' => array('id' => $region->getId()),
        );

        $this->client->request(
            'POST',
            '/administrator/api/addressing/city/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $parts = explode('/', $response->headers->get('location'));
        $id = array_pop($parts);
        $city = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\City')
            ->find($id);

        $this->assertTrue(201 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($city);
        $this->assertEquals($country->getId(),$city->getCountry()->getId());
        $this->assertEquals($region->getId(),$city->getRegion()->getId());
    }

    public function testGetCityAction()
    {
        $city = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\City')
            ->findOneBy(['name' => 'Alicante']);
        $id = $city->getId();

        $this->client->request(
            'GET',
            '/administrator/api/addressing/city/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $city->getId());
    }

    public function testPutCityAction()
    {
        $country = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Country')
            ->findOneBy(['iso2' => 'RU']);
        $city = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\City')
            ->findOneBy(['name' => 'Alicante']);
        $id = $city->getId();

        $data = array(
            'name' => 'Rivas',
            'country' => array('id' => $country->getId()),
        );

        $this->client->request(
            'PUT',
            '/administrator/api/addressing/city/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $city = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\City')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEquals($country->getId(),$city->getCountry()->getId());
    }

    public function testDeleteCityAction()
    {
        $city = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\City')
            ->findOneBy(['name' => 'Rivas']);
        $id = $city->getId();

        $this->client->request(
            'DELETE',
            '/administrator/api/addressing/city/'. $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $city = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\City')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEmpty($city);
    }

}
