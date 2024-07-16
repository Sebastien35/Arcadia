<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


class ConnectToEmployeTest extends WebTestCase
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

    public function testEmploye(): void
    {   
        
        $user = new User(
            'employe.ecfarcadia@gmail.com',
            'Studi123ECF',
            ['ROLE_EMPLOYE'],
            new \DateTimeImmutable(),
            null,
            1
        );
        $user->setPassword($this->passwordHasher->hashPassword($user, 'Studi123ECF'));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->client->loginUser($user);
        $this->client->request('GET', '/employe');
        $response = $this->client->getResponse();
        if($response->isRedirect()) {
            $this->client->followRedirect();
        }
        $this->assertResponseIsSuccessful();

        $this->client->request('GET', '/logout');
        $this->client->request('GET', '/employe');
        $this->assertResponseRedirects('/login');
        
    }
}
