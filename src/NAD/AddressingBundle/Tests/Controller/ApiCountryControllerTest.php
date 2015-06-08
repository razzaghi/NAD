<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\AddressingBundle\Tests\Controller;

use NAD\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiCountryControllerTest
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiCountryControllerTest extends AbstractWebTestCase
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
            '/api/addressing/country/',
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

    public function testGetCountryAction()
    {
        $country = $this
            ->em
            ->getRepository('NAD\AddressingBundle\Entity\Country')
            ->findOneBy(['iso2' => 'ES']);

        $this->client->request(
            'GET',
            '/api/addressing/country/' . $country->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $country->getId());
    }

}
