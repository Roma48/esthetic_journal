<?php

namespace AppBundle\Tests\Controller\Frontend;

use AppBundle\Tests\TestBaseWeb;

class CategoryControllerTest extends TestBaseWeb
{
    public function testIndex()
    {
        $client = $this->client;

        $category = $client->getContainer()->get('doctrine')->getManager()->getRepository('AppBundle:Category')->findOneBy(["id" => 1]);

        $crawler = $client->request('GET', '/category/' . $category->getSlug() . '/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
