<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\BackendUserBundle\Tests\Controller\Admin;

use NAD\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiControllerTest
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class APiControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostUserAction()
    {
        $users = $this
            ->em
            ->getRepository('NAD\BackendUserBundle\Entity\BackendUser')
            ->findBy(['username' => 'test_backend_user_nad']);

        foreach ($users as $user) {
            $this->em->remove($user);
        }
        $this->em->flush();

        $data = [
            'username' => 'test_backend_user_nad',
            'email' => 'test_backend_user_nad@nad.co',
            'plain_password' => 'test_backend_user_nad',
        ];

        $this->client->request(
            'POST',
            '/administrator/api/backenduser/',
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

        $this->client->request(
            'POST',
            '/administrator/api/backenduser/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEquals($result['errors']['email'], 'This value is already used.');
        $this->assertEquals($result['errors']['username'], 'This value is already used.');
        $this->assertTrue(400 === $statusCode);
    }

    public function testGetUsersAction()
    {
        $this->client->request(
            'GET',
            '/administrator/api/backenduser/',
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

    public function testGetUserAction()
    {
        $user = $this
            ->em
            ->getRepository('NAD\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['username' => 'test_backend_user_nad']);
        $id = $user->getId();

        $this->client->request(
            'GET',
            '/administrator/api/backenduser/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $user->getId());
    }

    public function testPutUserAction()
    {
        $user = $this
            ->em
            ->getRepository('NAD\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['username' => 'test_backend_user_nad']);
        $id = $user->getId();
        $data['email'] = 'test_backend_user_nad2@nad.co';

        $this->client->request(
            'PUT',
            '/administrator/api/backenduser/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $user = $this
            ->em
            ->getRepository('NAD\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['username' => 'test_backend_user_nad']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($user);
        $this->assertEquals($data['email'], $user->getEmail());
    }

    public function testDeletePageNodeAction()
    {
        $user = $this
            ->em
            ->getRepository('NAD\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['username' => 'test_backend_user_nad']);
        $id = $user->getId();

        $this->client->request(
            'DELETE',
            '/administrator/api/backenduser/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $user = $this
            ->em
            ->getRepository('NAD\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['username' => 'test_backend_user_nad']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($user);
    }

}
