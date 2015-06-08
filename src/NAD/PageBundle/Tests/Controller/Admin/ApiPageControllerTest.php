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
 * ApiPageControllerTest
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiPageControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostPageAction()
    {
        $data = [
            'locale' => 'en',
            'title' => 'AAA',
            'content' => 'test',
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
            'comment_status' => false,
        ];

        $this->client->request(
            'POST',
            '/administrator/api/page/',
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

    public function testGetPageAction()
    {
        $page = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Page')
            ->findOneBy(['title' => 'AAA']);

        $this->client->request(
            'GET',
            '/administrator/api/page/' . $page->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $page->getId());
    }

    public function testDeletePageAction()
    {
        $page = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Page')
            ->findOneBy(['title' => 'AAA']);
        $id = $page->getId();

        $this->client->request(
            'DELETE',
            '/administrator/api/page/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $page = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Page')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($page);
    }

    public function testPutPageAction()
    {
        $page = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Page')
            ->findOneBy(['locale' => 'en']);
        $id = $page->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/administrator/api/page/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $page = $this
            ->em
            ->getRepository('NAD\PageBundle\Entity\Page')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($page);
        $this->assertEquals($data['locale'], $page->getLocale());
    }

}
