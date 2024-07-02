<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AcceuilControllerTest extends WebTestCase
{   


    public function testAcceuil(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Arcadia');
    }
}
