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
 * ApiRegionControllerTest
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiRegionControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetRegionsAction()
    {
        $this->client->request(
            'GET',
            '/api/addressing/region/',
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

    public function testPostRegionAction()
    {
        $country = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Country')
            ->findOneBy(['iso2' => 'ES']);
        $data = array(
            'name' => 'AAA',
            'country' => array('id' => $country->getId()),
        );

        $this->client->request(
            'POST',
            '/administrator/api/addressing/region/',
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

        $region = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Region')
            ->find($id);

        $this->assertTrue(201 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($region);
        $this->assertEquals($data['name'], $region->getName());
        $this->assertEquals($data['country']['id'], $region->getCountry()->getId());
    }

    public function testGetRegionAction()
    {
        $region = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Region')
            ->findOneBy(['name' => 'AAA']);
        $id = $region->getId();

        $this->client->request(
            'GET',
            '/administrator/api/addressing/region/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $region->getId());
    }

    public function testPutRegionAction()
    {
        $country = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Country')
            ->findOneBy(['iso2' => 'RU']);
        $region = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Region')
            ->findOneBy(['name' => 'AAA']);
        $id = $region->getId();
        $data = array(
            'country' => array('id' => $country->getId()),
        );

        $this->client->request(
            'PUT',
            '/administrator/api/addressing/region/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $region = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Region')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEquals($data['country']['id'], $region->getCountry()->getId());
    }

    public function testDeleteRegionAction()
    {
        $region = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Region')
            ->findOneBy(['name' => 'AAA']);
        $id = $region->getId();

        $this->client->request(
            'DELETE',
            '/administrator/api/addressing/region/'. $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $region = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Region')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEmpty($region);
    }

}
