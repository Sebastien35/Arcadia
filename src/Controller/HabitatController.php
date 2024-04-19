<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;


use App\Entity\Habitat;
use App\Repository\HabitatRepository;
use App\Entity\Animal;
use App\Repository\AnimalRepository;


#[Route('/habitats', name: 'app_habitat_')]
class HabitatController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    )
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $habitats = $this->entityManager->getRepository(Habitat::class)->findAll();
        return $this->render('habitat/index.html.twig', [
            'controller_name' => 'HabitatController',
            'habitats' => $habitats,
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $habitat = $this->entityManager->getRepository(Habitat::class)->find($id);
        $animaux = $habitat->getAnimals();
        return $this->render('habitat/show.html.twig', [
            'controller_name' => 'HabitatController',
            'habitat' => $habitat,
            'animaux' => $animaux,
        ]);
    }
}
