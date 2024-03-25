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
        $selection = $documentManager->createQueryBuilder("App\Document\AnimalVisit")
            ->select('animalId') 
            ->sort('visits', 'desc')
            ->limit(4)
            ->getQuery()
            ->execute();
    
        $animalIds = [];
        foreach ($selection as $visit) {
            $animalId = $visit->getAnimalId(); 
            $animalIds[] = $animalId;
            
        }
        if(empty($animalIds)){
            $animalIds = [1,2,3,4];
        }
        if(4 > count($animalIds)){
            $additionalAnimalIds = $animalRepository->findTopAnimalsByName(4 - count($animalIds));
            $animalIds = array_merge($animalIds, $additionalAnimalIds);
        }
            
        return $animalIds;
    }
}

