<?php

namespace tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\DomCrawler\Link;

class HomeControllerTest extends WebTestCase
{
    public function testHomepageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }


    public function testHomepageH1()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertSame(1, $crawler->filter('h1')->count());
    }


    /*public function testLinkContactOnHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->filter('a:contains("Ecole de tennis")')->eq(2)->link();
        $client->click($link);

        $this->assertDirectoryIsWritable('/categorie/lecole-de-tennis');
    }*/

}