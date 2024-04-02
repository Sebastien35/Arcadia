<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ODM\MongoDB\DocumentManager;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Document\AnimalVisit;
use App\Entity\InfoAnimal;
use App\Exception\AnimalNotFoundException;
use App\Repository\InfoAnimalRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Util\Json;
use App\Entity\AdditionalImages;
use App\Repository\AdditionalImagesRepository;

#[Route('/animal', name: 'app_animal_')]
class AnimalController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private DocumentManager $dm,
        )
    {
        $this->entityManager=$entityManager;
        $this->serializer=$serializer;
        $this->dm = $dm;
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function showAnimal(int $id, 
    AnimalRepository $animalRepo, 
    DocumentManager $dm, 
    InfoAnimalRepository $infoAnimalRepo, 
    ): Response
    {   
        $animal = $animalRepo->find($id);
        if(!$animal){
            throw new AnimalNotFoundException(); 
        }
        $infoAnimal = $infoAnimalRepo->findBy(
            ['animal' => $id],
            ['createdAt' => 'DESC'],
            1
        );

        $visit = $dm->getRepository(AnimalVisit::class)->findOneBy(['animalId' => $id]);
        if(!$visit){
            $visit = new AnimalVisit();
            $visit->setAnimalId($id);
            $visit->setAnimalName($animalRepo->find($id)->getPrenom());
        }
        $visit->incrementVisits();
        $dm->persist($visit);
        $dm->flush();
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
            'infoAnimal' => $infoAnimal,
        ]);
    }

    #[Route('/getImages/{id}', name: 'getImages', methods: ['GET'])]
    public function getImages(int $id, AnimalRepository $animalRepo, AdditionalImagesRepository $imageRepo, SerializerInterface $serializer): JsonResponse
    {   
    try{
        $images = $imageRepo->findBy(['animal' => $id], ['createdAt' => 'DESC']);
        if(!$images){
            $animalImages = null; 
        }
        return new JsonResponse($serializer->serialize($images, 'json', ['groups' => 'image:read']));
    }
    catch(\Exception $e){
        return new JsonResponse($e->getMessage(), 500);
    }
    }
    

    
}
