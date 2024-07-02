<?php

namespace App\Repository;

use App\Document\AnimalVisit;
use App\Entity\Animal;
use MongoDb\Collection;
use MongoDN\BSON\ObjectID;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use App\Repository\AnimalRepository;

class AnimalVisitRepository{

    
    public function top4(DocumentManager $documentManager, AnimalRepository $animalRepository){
        $animalIds = [];
        try{
        $selection = $documentManager->createQueryBuilder("App\Document\AnimalVisit")
            ->select('animalId') 
            ->sort('visits', 'desc')
            ->limit(4)
            ->getQuery()
            ->execute();
        } catch (\Exception $e) {
            $selection = [];
        }
        foreach ($selection as $visit) {
            $animalId = $visit->getAnimalId(); 
            $animalIds[] = $animalId;
        }
        if(empty($animalIds)){
            try{
            $additionalIds = $animalRepository->findfirstfourids(); 
            $animalIds = array_merge($animalIds, $additionalIds);
            } catch (\Exception $e) {
                $animalIds = [];
            }
        }
        return $animalIds;
    }

   


    
}
