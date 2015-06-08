<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\PageBundle\Tests\Controller\Admin;

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

    public function testPostPageNodeAction()
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
            '/administrator/api/page/category/',
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

    public function testGetPageNodesAction()
    {
        $this->client->request(
            'GET',
            '/administrator/api/page/category/?locale=en'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));

    }

    public function testGetPageNodeAction()
    {
        $pageNode = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Category')
            ->findOneBy(['title' => 'AAA']);

        $this->client->request(
            'GET',
            '/administrator/api/page/category/' . $pageNode->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $pageNode->getId());
    }

    public function testPutPageNodeAction()
    {
        $pageNode = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Category')
            ->findOneBy(['title' => 'AAA']);
        $id = $pageNode->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/administrator/api/page/category/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $pageNode = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Category')
            ->findOneBy(['title' => 'AAA']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($pageNode);
        $this->assertEquals($data['locale'], $pageNode->getLocale());
    }

    public function testDeletePageNodeAction()
    {
        $pageNode = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Category')
            ->findOneBy(['title' => 'AAA']);
        $id = $pageNode->getId();

        $this->client->request(
            'DELETE',
            '/administrator/api/page/category/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $pageNode = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Category')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($pageNode);
    }

}
