<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


class ConnectTest extends WebTestCase
{   
    private $client;
    private $entityManager;
    private $passwordHasher;


    public function setUp(): void  {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()
              ->get('doctrine')
              ->getManager();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        //Purge et recrée la base de données
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $this->passwordHasher = $this->client->getContainer()->get('security.password_hasher');
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    public function testAdmin(): void
    {   
        
        $user = new User(
            'jose.ecfarcadia@gmail.com',
            'Studi123ECF',
            ['ROLE_ADMIN'],
            new \DateTimeImmutable(),
            null,
            1
        );
        $user->setPassword($this->passwordHasher->hashPassword($user, 'Studi123ECF'));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->client->loginUser($user);

        $this->client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();

        $this->client->request('GET', '/logout');
        $this->client->request('GET', '/admin');  
        $this->assertResponseRedirects('/login');
        
        
        
    }
}
