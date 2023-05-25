<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CursoControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideSuccesUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testPageNotFound(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/cursos/6');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isNotFound());
    }


    /**
     * Listado de urls que devuelven un 200.
     *
     * [
     *  ['/path/found'],
     *  ...
     * ]
     *
     * return array.
     */
    public function provideSuccesUrls(): array
    {
        return [
            ['/api/cursos/1'],
            ['/api/cursos/2'],
            ['/api/cursos/3'],
            ['/api/cursos/4']
        ];
    }
}
