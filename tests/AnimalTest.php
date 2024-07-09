<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Animal;
use App\Entity\Habitat;


class AnimalTest extends KernelTestCase
{   
    private $entityManager;
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    

    public function testCreateAnimal(){
        //Pikachu je te choisis
        $habitat = new Habitat();
        $habitat->setNom('Forêt');
        $habitat->setDescription('Forêt de bambou');
        $this->entityManager->persist($habitat);
        $this->entityManager->flush();
        $pokemon = new Animal();
        $Maintenant = new \DateTimeImmutable();
        $pokemon->setPrenom('Pikachu')
                ->setRace('Electrique')
                ->setCreatedAt($Maintenant)
                ->setUpdatedAt(null)
                ->setHabitat($habitat);
        $this->entityManager->persist($pokemon);
        $this->entityManager->flush();

        //Pikachu, Reviens !
        $animalRepository = $this->entityManager->getRepository(Animal::class);
        $PikachuRevenu = $animalRepository->findById($pokemon->getId())[0];

        $this->assertEquals('Pikachu', $PikachuRevenu->getPrenom());
        $this->assertEquals('Electrique', $PikachuRevenu->getRace());
        $this->assertEquals($Maintenant, $PikachuRevenu->getCreatedAt());
        $this->assertEquals(null, $PikachuRevenu->getUpdatedAt());
        $this->assertEquals($habitat, $PikachuRevenu->getHabitat());

        $this->entityManager->remove($PikachuRevenu);
        $this->entityManager->remove($habitat); 
        $this->entityManager->flush();
    }


        
    


}
