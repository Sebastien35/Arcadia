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
use App\Repository\AnimalVisitRepository;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\ServiceRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Form\AvisType;


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
    ServiceRepository $serviceRepository,
    AnimalRepository $animalRepository,
    AnimalVisitRepository $visitRepository,
    DocumentManager $documentManager

    ): Response
{
    $avis = $avisRepository->findBy(['validation' => 1]);
    $horaires = $horaireRepository->findAll();
    $habitats = $habitatRepository->findAll();
    $services = $serviceRepository->findAll();
    $MostPopularAnimals = $visitRepository->top4($documentManager, $animalRepository);
    if(!empty($MostPopularAnimals) && count($MostPopularAnimals) < 4){
        $additionalIds = $animalRepository->getDifferentIds($MostPopularAnimals);
        $MostPopularAnimals = array_merge($MostPopularAnimals, $additionalIds);
    }
    $AnimauxElus = $animalRepository->findIDs($MostPopularAnimals);
    $avisForm = $this->createForm(AvisType::class);
    
    return $this->render('accueil/index.html.twig', [
        'controller_name' => 'AcceuilController',
        'avis' => $avis,
        'horaires' => $horaires,
        'habitats' => $habitats,
        'services' => $services,
        'animaux' => $AnimauxElus,
        'avisForm' => $avisForm->createView()
    ]);
}


}
