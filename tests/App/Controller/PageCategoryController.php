<?php

namespace tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\DomCrawler\Link;

class PageCategoryController extends WebTestCase
{

    /**
     * @param $url
     * @param $statusExpected
     *
     * @dataProvider urls
     */
    public function testUrls($url, $method, $statusExpected)
    {
        $client = static::createClient();
        $client->request($method, $url);

        $this->assertSame($statusExpected, $client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     * Tableau d'URLs à tester via la méthode testUrls
     */
    public function urls(){
        return [
            ['/categorie/', 'GET', 404],
            ['/categorie/lecole-de-tennis', 'GET' , 200],
            ['/categorie/tennis-adulte', 'GET' , 200],
            ['/categorie/competitions', 'GET' , 200],
            ['/categorie/reserver-un-court', 'GET' , 404],
            ['/categorie/page', 'GET' , 404],
            ['/categorie/contact', 'GET' , 404],
            ['/categorie/le-club', 'GET' , 200]
        ];
    }

}