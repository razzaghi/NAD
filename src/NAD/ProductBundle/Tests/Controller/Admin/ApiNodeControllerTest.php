<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ProductBundle\Tests\Controller\Admin;

use NAD\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiNodeControllerTest
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiNodeControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostProductNodeAction()
    {
        $data = [
            'locale' => 'en',
            'title' => 'AAA',
            'description' => 'test',
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
        ];

        $this->client->request(
            'POST',
            '/administrator/api/product/category/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertEmpty($content);
        $this->assertTrue(201 === $statusCode);
    }

    public function testGetProductNodesAction()
    {
        $this->client->request(
            'GET',
            '/administrator/api/product/category/?locale=en'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));
    }

    public function testGetProductNodeAction()
    {
        $ProductNode = $this
            ->em
            ->getRepository('NAD\ProductBundle\Entity\Category')
            ->findOneBy(['title' => 'AAA']);

        $this->client->request(
            'GET',
            '/administrator/api/product/category/' . $ProductNode->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $ProductNode->getId());
    }

    public function testPutProductNodeAction()
    {
        $ProductNode = $this
            ->em
            ->getRepository('NAD\ProductBundle\Entity\Category')
            ->findOneBy(['title' => 'AAA']);
        $id = $ProductNode->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/administrator/api/product/category/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $ProductNode = $this
            ->em
            ->getRepository('NAD\ProductBundle\Entity\Category')
            ->findOneBy(['title' => 'AAA']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($ProductNode);
        $this->assertEquals($data['locale'], $ProductNode->getLocale());
    }

    public function testDeleteProductNodeAction()
    {
        $ProductNode = $this
            ->em
            ->getRepository('NAD\ProductBundle\Entity\Category')
            ->findOneBy(['title' => 'AAA']);
        $id = $ProductNode->getId();

        $this->client->request(
            'DELETE',
            '/administrator/api/product/category/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $ProductNode = $this
            ->em
            ->getRepository('NAD\ProductBundle\Entity\Category')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($ProductNode);
    }
}
