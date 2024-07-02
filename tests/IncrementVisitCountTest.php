<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Document\AnimalVisit;
use Doctrine\ODM\MongoDB\DocumentManager;

class IncrementVisitCountTest extends WebTestCase
{
    private $dm;

    protected function setUp(): void
    {
        parent::setUp();

        // Assuming you have a way to inject or access the DocumentManager
        $this->dm = static::getContainer()->get(DocumentManager::class);
    }

    public function testIncrementVisits()
    {
        try {
            $animalVisit = new AnimalVisit();
            $animalVisit
                ->setAnimalId(1)
                ->setAnimalName('test animal')
                ->setVisits(0);
                
            $this->dm->persist($animalVisit);
            echo("Persisted");
            $this->dm->flush(); // Save the document to the database
            echo("Flushed");

            // Verify initial visits
            $initialVisits = $animalVisit->getVisits();
            echo("Initial visits: ".$initialVisits);
            $this->assertSame(0, $initialVisits);

            // Increment visits
            $animalVisit->incrementVisits();

            // Persist the updated document to ensure changes are saved
            $this->dm->persist($animalVisit);
            $this->dm->flush(); // Commit the changes to the database
            echo("Updated and flushed");

            // Refresh the document from the database to get the updated state
            $this->dm->refresh($animalVisit);

            // Now, visits should be incremented by 1
            $this->assertSame(1, $animalVisit->getVisits());
        } catch (\Exception $e) {
            echo($e->getMessage());
        }
    }
}