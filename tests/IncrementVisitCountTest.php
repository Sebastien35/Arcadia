<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Document\AnimalVisit;
use Doctrine\ODM\MongoDB\DocumentManager;

class IncrementVisitCountTest extends WebTestCase
{
    private $documentManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->documentManager = static::getContainer()->get(DocumentManager::class);
    }

    public function testIncrementVisits()
    {
        $animalVisit = new AnimalVisit();
        $animalVisit
            ->setAnimalId(0)
            ->setAnimalName('test animal')
            ->setVisits(0);
        $this->documentManager->persist($animalVisit);
        $this->documentManager->flush(); 
        $initialVisits = $animalVisit->getVisits();
        $this->assertSame(0, $initialVisits);
        $animalVisit->incrementVisits();
        $this->documentManager->persist($animalVisit);
        $this->documentManager->flush(); 
        $this->documentManager->refresh($animalVisit);
        $this->assertSame(1, $animalVisit->getVisits());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->documentManager->createQueryBuilder(AnimalVisit::class)
            ->remove()
            ->field('animalId')->equals(0)
            ->getQuery()
            ->execute();
    }

}