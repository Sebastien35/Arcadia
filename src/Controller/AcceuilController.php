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

        ): Response
    {
        $avis = $avisRepository->findAll();
        $horaires = $horaireRepository->findAll();
        $habitats=$this->entityManager->getRepository(Habitat::class)->findAll();
        $services=$this->entityManager->getRepository(Service::class)->findAll();
        
        // Récupérer 4 animaux aléatoires
        // Récupérer l'id minimum et maximum des animaux
        $idQuery = $this->entityManager->createQuery('SELECT MIN(a.id) AS min_id, MAX(a.id) AS max_id FROM App\Entity\Animal a');
        $animalIds = $idQuery->getResult();
        $minId = $animalIds[0]['min_id'];
        $maxId = $animalIds[0]['max_id'];
        //Initialiser un tableau vide pour stocker les animaux
        $animaux = [];
        $randomIds = [];
        // Boucle pour récupérer 5 animaux aléatoires
        for ($i = 0; $i < 4; $i++) {
            // Générer un id aléatoire
            $randomId = rand($minId, $maxId);
            // Ajouter l'id aléatoire dans un tableau pour vérifier s'il n'est pas déjà utilisé
            $randomIds[] = $randomId; 
            // Récupérer l'animal correspondant à l'id aléatoire
            $animal = $this->entityManager->getRepository(Animal::class)->find($randomId);
            // Si l'animal existe et n'est pas déjà dans le tableau, on l'ajoute
            if ($animal && !in_array($animal, $animaux)) {
                // Ajouter l'animal dans le tableau
                $animaux[] = $animal;
            } else {
                // Sinon, on décrémente le compteur pour refaire une itération jusqu'à avoir 5 animaux
                $i--;
            }
        }
        // Récupérer les animaux correspondant aux ids aléatoires
        $animaux = $this->entityManager->getRepository(Animal::class)->findBy(['id' => $randomIds]);
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AcceuilController',
            'avis' => $avis,
            'horaires' => $horaires,
            'habitats' => $habitats,
            'services' => $services,
            'animaux' => $animaux,
        ]);
    }
}
