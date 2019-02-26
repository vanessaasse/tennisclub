<?php

namespace tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
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
            ['/event/', 'GET', 404],
            ['/agenda/', 'GET' , 200],
        ];
    }

}