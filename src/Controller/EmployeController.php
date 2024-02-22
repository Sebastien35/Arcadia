<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Entity\Repas;
use App\Repository\RepasRepository;

use App\Form\RepasType;




#[Route('/employe', name: 'app_employe_')]
class EmployeController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $avisList = $this->entityManager->getRepository(Avis::class)->findAll();
        $services = $this->entityManager->getRepository(Service::class)->findAll();
        $animaux = $this->entityManager->getRepository(Animal::class)->findAll();
        $nourritures = $this->entityManager->getRepository(Repas::class)->findAll();
        $form = $this->createForm(RepasType::class);
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
            'avisList'=>$avisList,
            'services'=>$services,
            'animaux'=>$animaux,
            'nourritures'=>$nourritures,
            'form' => $form->createView()
            
        ]);
    }

    #[Route('/services/edit/{id}', name: 'edit_service', methods:['PUT'])]
    public function editService(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $service = $this->entityManager->getRepository(Service::class)->find($id);
        $service->setNom($data['nom']);
        $service->setDescription($data['description']);
        $this->entityManager->persist($service);
        $this->entityManager->flush();
        return new JsonResponse(['status' => 'Service updated!'], Response::HTTP_OK);
    }

    #[Route('/animal/repas/new', name: 'createRepas', methods:['POST'])]
    public function newRepas(Request $request, SerializerInterface $serializer):Response
    {
        $form = $this->createForm(RepasType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repas = $form->getData();
            $animal = $form->get('animal')->getData();
            $nourriture = $animal->getInfoAnimal()->getNourriture();
            $repas->setAnimal($animal);
            $repas->setNourriture($nourriture);
            $repas->setDateTime($form->get('datetime')->getData());
            $repas->setQuantite($form->get('quantite')->getData());

            $this->entityManager->persist($repas);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_employe_index');
        }
    }
    
}
