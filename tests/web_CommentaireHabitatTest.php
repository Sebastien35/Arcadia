<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\CommentaireHabitat;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Habitat;
use App\Entity\User;
use App\DataFixtures\HabitatFixture;

class web_CommentaireHabitatTest extends WebTestCase {
    private $client;
    private $entityManager;
    private $passwordHasher;
    protected function setUp(): void {

        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()
              ->get('doctrine')
              ->getManager();
        $this->passwordHasher = $this->client->getContainer()->get('security.password_hasher');
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        //Purge et recrée la base de données
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    public function testCommentaireHabitat(){
        try{
        $habitat = new Habitat();
        $habitat
                ->setNom('Forêt')
                ->setDescription('Forêt de bambou');
        $this->entityManager->persist($habitat);
        $this->entityManager->flush();
        
        }catch(\Exception $e){
            $this->fail($e->getMessage(), 'Erreur lors de la création de l\'habitat');
        }
        try{
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
        }catch(\Exception $e){
            $this->fail($e->getMessage(), 'Erreur lors de la création de l\'utilisateur');
        }
        try{
        // dd($user);
        $this->client->loginUser($user);
        } catch(\Exception $e){
            $this->fail($e->getMessage(), 'Erreur lors de la connexion');
        }
        try{
        $this->client->request('POST', 'veterinaire/habitat/commentaire/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'habitat' => 1, // Assuming the ID of the habitat created by the fixture is 1
            'commentaire' => 'Test Comment'
        ]));
        
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $postedComment = $this->entityManager->getRepository(CommentaireHabitat::class)->findOneBy(['commentaire' => 'Test Comment']);
         
        }catch(\Exception $e){  
            $this->fail($e->getMessage(), 'Erreur lors de la création du commentaire');
        }

        $this->assertNotNull($postedComment);
        $habitatId = $postedComment->getHabitat()->getId();
        
        $this->client->request('DELETE', '/admin/comment/delete/'.$habitatId);
        $this->assertNull($this->entityManager->getRepository(CommentaireHabitat::class)->findOneBy(['commentaire' => 'Test Comment']));

    }
    protected function tearDown(): void {
        parent::tearDown();
        
        $this->entityManager->close();
        $this->entityManager = null;
    }




}

