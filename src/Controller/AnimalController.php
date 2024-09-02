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
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/animal', name: 'app_animal_')]
class AnimalController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private DocumentManager $documentManager,
        )
    {
        $this->entityManager=$entityManager;
        $this->serializer=$serializer;
        $this->documentManager = $documentManager;
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function showAnimal(int $id, 
    AnimalRepository $animalRepo, 
    DocumentManager $documentManager, 
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

        $visit = $documentManager->getRepository(AnimalVisit::class)->findOneBy(['animalId' => $id]);
        if(!$visit){
            $visit = new AnimalVisit();
            $visit->setAnimalId($id);
            $visit->setAnimalName($animalRepo->find($id)->getPrenom());
        }
        $visit->incrementVisits();
        $documentManager->persist($visit);
        $documentManager->flush();
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
            'infoAnimal' => $infoAnimal,
        ]);
    }

    #[IsGranted('ROLE_USER',)]
    #[Route('/all', name: 'getAnimals', methods: ['GET'])]
    public function getAnimals(AnimalRepository $animalRepository): JsonResponse
    {
        try{
        $animals = $animalRepository->findAll();
        $context = ['groups' => 'animal:read'];
        return JsonResponse::fromJsonString($this->serializer->serialize(
            $animals, 'json', $context),
            Response::HTTP_OK);
        
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'An error occurred',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/getImages/{id}', name: 'getImages', methods: ['GET'])]
    public function getImages(int $id, AnimalRepository $animalRepo, AdditionalImagesRepository $imageRepo, SerializerInterface $serializer): JsonResponse
    {
    try{
        $images = $imageRepo->findBy(['animal' => $id], ['createdAt' => 'DESC']);
        if(!$images){
            $images = null;
        }
        return new JsonResponse($serializer->serialize($images, 'json', ['groups' => 'image:read']));
    }
    catch(\Exception $e){
        return new JsonResponse($e->getMessage(), 500);
    }
    }
    

    
}
