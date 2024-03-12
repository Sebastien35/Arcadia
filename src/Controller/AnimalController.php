<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\MongoDB\DocumentManager;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Document\AnimalVisit;
use App\Entity\InfoAnimal;

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
    public function showAnimal(int $id): Response
    {
        $animal = $this->entityManager->getRepository(Animal::class)->find($id);
        $infoAnimal = $this->entityManager->getRepository(InfoAnimal::class)->findBy(
            ['animal' => $id],
            ['createdAt' => 'DESC'],
            1
        );
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
            'infoAnimal' => $infoAnimal,
            
        ]);

    }

    #[Route('/visit/{id}', name: 'visit', methods: ['POST'])]
    public function incrementVisit(int $id): Response
    {
        try{
        $visit = $this->dm->getRepository(AnimalVisit::class)->findOneBy(['animalId' => $id]);
        if(!$visit){
            $visit = new AnimalVisit();
            $visit->setAnimalId($id);
        }
        $visit->incrementVisits();

        $this->dm->persist($visit);
        $this->dm->flush();
        return new Response(status: 200);
    }catch(\Exception $e){
        return new Response('error' . $e->getMessage()  , 500);
    }
    return new Response('error');
    }
}
