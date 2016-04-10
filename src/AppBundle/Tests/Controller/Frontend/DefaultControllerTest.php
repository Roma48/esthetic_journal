<?php

namespace AppBundle\Tests\Controller\Frontend;

use AppBundle\Tests\TestBaseWeb;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends TestBaseWeb
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
