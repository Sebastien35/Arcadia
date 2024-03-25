<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AvisRepository;
use App\Repository\HoraireRepository;
use App\Entity\Habitat;
use App\Entity\Service;
use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;



class AcceuilController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
        )
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/', name: 'app_acceuil')]
    public function index(
    AvisRepository $avisRepository, 
    HoraireRepository $horaireRepository,
    HabitatRepository $habitatRepository,
    EntityManagerInterface $entityManager,
    AnimalRepository $animalRepository
    ): Response
{
    $avis = $avisRepository->findAll();
    $horaires = $horaireRepository->findAll();
    $habitats = $this->entityManager->getRepository(Habitat::class)->findAll();
    $services = $this->entityManager->getRepository(Service::class)->findAll();
    


    return $this->render('accueil/index.html.twig', [
        'controller_name' => 'AcceuilController',
        'avis' => $avis,
        'horaires' => $horaires,
        'habitats' => $habitats,
        'services' => $services,
    ]);
}


}
