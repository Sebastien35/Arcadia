<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Animal;
use App\Repository\AnimalRepository;

#[Route('/animal', name: 'app_animal_')]
class AnimalController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        )
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {

        $animaux=$this->entityManager->getRepository(Animal::class)->findAll();
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animaux' => $animaux,
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function showAnimal(int $id): Response
    {
        $animal = $this->entityManager->getRepository(Animal::class)->find($id);
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
            
        ]);

    }
}
