<?php

namespace tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\DomCrawler\Link;

class PageControllerTest extends WebTestCase
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
            ['/page/', 'GET', 404],
            ['/page/tarifs-et-inscription', 'GET' , 200],
            ['/page/inscription-au-tennis-club', 'GET' , 200],
            ['/page/contact', 'GET' , 200],
            ['/page/reserver-un-court', 'GET' , 200],
            ['/page/tarifs-et-inscription', 'POST' , 200],
            ['/page/inscription-au-tennis-club', 'POST' , 200],
            ['/page/contact', 'POST' , 200],
            ['/page/reserver-un-court', 'POST' , 200],
            ['/page/evenement', 'GET' , 404],
            ['/page/actualites', 'GET' , 404]
        ];
    }

}