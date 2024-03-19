<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\InfoAnimal;

#[Route('/infoanimal', name: 'app_info_animal')]
class InfoAnimalController extends AbstractController
{   
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
        )
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }


   #[Route('/all', name: 'all', methods: ['GET'])]
    public function all(): JsonResponse
    {   
        if ($this->getUser() === null) {
            return JsonResponse::fromJsonString('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        try{
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $infoAnimals = $this->entityManager->getRepository(InfoAnimal::class)->findAll();
        return JsonResponse::fromJsonString($this->serializer->serialize($infoAnimals, 'json',
    ['groups'=>['info_animal','animal:read']]), Response::HTTP_OK);
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
