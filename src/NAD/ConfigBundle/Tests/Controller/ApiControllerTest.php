<?php

/*
 * This file is part of the NAD package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NAD\ConfigBundle\Tests\Controller;

use NAD\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiControllerTest
 *
 * @author Mohammadreza Razzaghi <razzaghi229@gmail.com>
 */
class ApiControllerTest extends AbstractWebTestCase
{

    /**
     * @var array
     */
    private $config = array();

    public function setUp()
    {
        parent::setUp();

        $this->config = static::$kernel->getContainer()->getParameter('nad_config');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetConfigAction()
    {

        $this->client->request(
            'GET',
            '/api/en/config/'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(isset($result['settings']));
        $this->assertTrue(isset($result['locale']));

        foreach ($result['locale']['available'] as $locale) {
            $this->assertNotFalse(array_search($locale, $this->locales));
        }
    }

}
