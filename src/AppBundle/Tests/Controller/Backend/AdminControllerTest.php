<?php

namespace AppBundle\Tests\Controller\Backend;

use AppBundle\Entity\Category;
use AppBundle\Entity\Image;
use AppBundle\Entity\User;
use AppBundle\Form\ArticleType;
use AppBundle\Tests\TestBaseWeb;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends TestBaseWeb
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(' ', $crawler->filter('#content')->text());
    }

    public function testArticlesPageAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/articles/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('All Articles', $crawler->filter('#content h1')->text());
    }

    public function testImagesPageAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/images/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('All Images', $crawler->filter('#content h1')->text());
    }

    public function testCategoriesPageAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/categories/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('All Categories', $crawler->filter('#content h1')->text());
    }

    public function testCommentsPageAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/comments/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('All Comments', $crawler->filter('#content h1')->text());
    }

    public function testUsersPageAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/users/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('All Users', $crawler->filter('#content h1')->text());
    }
}
