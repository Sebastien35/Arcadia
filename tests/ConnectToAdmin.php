<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConnectTest extends WebTestCase
{
    public function testAdmin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin');

        $this->assertResponseRedirects('/login', 401);
        
    }
}
