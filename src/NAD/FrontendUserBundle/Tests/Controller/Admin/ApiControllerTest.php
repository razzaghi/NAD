<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\FrontendUserBundle\Tests\Controller\Admin;

use NAD\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiControllerTest
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiControllerTest extends AbstractWebTestCase
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
            ->getRepository('NAD\FrontendUserBundle\Entity\FrontendUser')
            ->findBy(['username' => 'test_frontend_user_nad']);

        foreach ($users as $user) {
            $this->em->remove($user);
        }
        $this->em->flush();

        $data = [
            'username' => 'test_frontend_user_nad',
            'email' => 'test_frontend_user_nad@nad.co',
            'plain_password' => 'test_frontend_user_nad',
        ];

        $this->client->request(
            'POST',
            '/administrator/api/frontenduser/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->client->request(
            'POST',
            '/administrator/api/frontenduser/',
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
            '/administrator/api/frontenduser/',
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
            ->getRepository('NAD\FrontendUserBundle\Entity\FrontendUser')
            ->findOneBy(['username' => 'test_frontend_user_nad']);
        $id = $user->getId();

        $this->client->request(
            'GET',
            '/administrator/api/frontenduser/' . $id,
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
            ->getRepository('NAD\FrontendUserBundle\Entity\FrontendUser')
            ->findOneBy(['username' => 'test_frontend_user_nad']);
        $id = $user->getId();

        $data = array(
            'id' => 134,
            'username' => 'volgodark',
            'email' => 'volgodark@gmail.com',
            'created_at' => '2015-05-26T05:04:54-0700',
            'updated_at' => '2015-05-26T05:04:54-0700',
            'last_login' => '2015-05-26T05:04:54-0700',
            'phone' => '+123',
            'enabled' => true,
            'locked' => false,
            'orders' => array(),
            'cart' => array(),
            'orders' => array(
                0 => array(
                    'id' => '248',
                )
            ),
        );

        $this->client->request(
            'PUT',
            '/administrator/api/frontenduser/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        var_dump($statusCode);
        var_dump($response);
        exit();

        $user = $this
            ->em
            ->getRepository('NAD\FrontendUserBundle\Entity\FrontendUser')
            ->findOneBy(['username' => 'test_frontend_user_nad']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($user);
    }

    public function testDeletePageNodeAction()
    {
        $user = $this
            ->em
            ->getRepository('NAD\FrontendUserBundle\Entity\FrontendUser')
            ->findOneBy(['username' => 'test_frontend_user_nad']);
        $id = $user->getId();

        $this->client->request(
            'DELETE',
            '/administrator/api/frontenduser/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $user = $this
            ->em
            ->getRepository('NAD\FrontendUserBundle\Entity\FrontendUser')
            ->findOneBy(['username' => 'test_frontend_user_nad']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($user);
    }

}
