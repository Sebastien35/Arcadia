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
use App\Entity\DemandeContact;
use App\Form\RepasType;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Service\MailerService;

#[Route('/employe', name: 'app_employe_')]
class EmployeController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager,)
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
        $demandes = $this->entityManager->getRepository(DemandeContact::class)->findAll();
        $form = $this->createForm(RepasType::class);
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
            'avisList'=>$avisList,
            'services'=>$services,
            'animaux'=>$animaux,
            'nourritures'=>$nourritures,
            'demandes'=>$demandes,
            'form' => $form->createView()
            
        ]);
    }

    #[Route('/services/edit/{id}', name: 'edit_service', methods:['PUT'])]
    public function editService(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $service = $this->entityManager->getRepository(Service::class)->find($id);
        if (!$service) {
            throw $this->createNotFoundException('Service with id ' . $id . ' does not exist!');
        }
        if (empty($data['nom']) || empty($data['description'])) {
            $service->setnom($service->getNom());
        }else{
            $service->setNom($data['nom']);
        }
        if (empty($data['description'])) {
            $service->setDescription($service->getDescription());
        }else{
            $service->setDescription($data['description']);
        }
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
        
        // Get the last instance of InfoAnimal associated with the animal
        $infoAnimal = $animal->getInfoAnimals()->last();
        
        if (!$infoAnimal) {
            $this->addFlash('error', 'Le vétérinaire n\'a pas encore défini ce que mange cet animal.');
            return new RedirectResponse($this->generateUrl('app_employe_index'));
        }
        
        $nourriture = $infoAnimal->getNourriture();
        
        $repas->setAnimal($animal);
        $repas->setNourriture($nourriture);
        $repas->setDateTime($form->get('datetime')->getData());
        $repas->setQuantite($form->get('quantite')->getData());
        
        $this->entityManager->persist($repas);
        $this->entityManager->flush();
        
        $this->addFlash('success', 'Le repas a bien été enregistré.');
        return new RedirectResponse($this->generateUrl('app_employe_index'));
    }
    
    return new Response('Invalid data.', Response::HTTP_BAD_REQUEST);
}

    #[Route('/demande/repondre/{id}', name: 'repondre_demande', methods:['POST'])]
    public function repondreDemande(Request $request, MailerService $mailerService): Response
    {
    try {
    
        $data = json_decode($request->getContent(), true);
        $text = $data['response'];
        $id = $request->attributes->get('id');
        $destinataire = $this->entityManager->getRepository(DemandeContact::class)->find($id)->getMail();
        $mailerService->sendResponseMail($destinataire, $text);
        $demande=$this->entityManager->getRepository(DemandeContact::class)->find($request->attributes->get('id'));
        $demande->setAnsweredAt(new \DateTimeImmutable());
        $demande->setAnswered(true);
        $this->addFlash('success', 'Votre réponse a bien été envoyée.');
        $this->entityManager->persist($demande);
        $this->entityManager->flush();
    } catch (\Exception $e) {
        $this->addFlash('error', 'Une erreur est survenue: ' . $e->getMessage());
    }

    return new RedirectResponse($this->generateUrl('app_employe_index'));
    }


    #[Route('/avis/valider/{id}',name: 'validerAvis', methods: 'POST')]
    public function validerAvis(int $id, Request $request): JsonResponse
    {
        $avis=$this->entityManager->getRepository(Avis::class)->find($id);
        if (!$avis){
            throw $this->createNotFoundException(
                'No avis found for id '.$id
            );
        }else{
        $avis->setValidation(true);
        $this->entityManager->flush();
        return new JsonResponse(null, Response::HTTP_OK);

        }
        

        
    }
        



    #[Route('/avis/delete/{id}',name: 'delete', methods: 'DELETE')]
    public function delete(int $id):Response
    {
        $avis = $this->entityManager->getRepository(Avis::class)->find($id);
        if (!$avis){
            throw $this->createNotFoundException(
                'No avis found for id '.$id
            );
        }
        $this->entityManager->remove($avis);
        $this->entityManager->flush();
        return new JsonResponse(null, Response::HTTP_OK);
    }



}
