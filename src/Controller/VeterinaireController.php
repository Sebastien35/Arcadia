<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;


use App\Entity\Animal;
use App\Entity\CommentaireHabitat;
use App\Repository\AnimalRepository;
use App\Form\animalFormType;
use App\Form\EditAnimalType;

use App\Entity\Habitat;
use App\Repository\HabitatRepository;
use App\Entity\Nourriture;
use App\Repository\NourritureRepository;
use App\Entity\InfoAnimal;
use App\Repository\InfoAnimalRepository;
use App\Entity\Repas;
use App\Repository\RepasRepository;
use App\Repository\CommentaireHabitatRepository;


use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/veterinaire', name: 'app_veterinaire_')]
class VeterinaireController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    )
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'index')]
    public function index(AnimalRepository $animalRepo, NourritureRepository $nourritureRepo): Response
    {
        $nourritures = $nourritureRepo->findAll();
        $animaux = $animalRepo->findAll();
        $habitats = $this->entityManager->getRepository(Habitat::class)->findAll();
        $createAnimalForm = $this->createForm(animalFormType::class);
        $editAnimalForm = $this->createForm(EditAnimalType::class);
        $repas= $this->entityManager->getRepository(InfoAnimal::class)->findAll();
        return $this->render('veterinaire/index.html.twig', [
            'controller_name' => 'VeterinaireController',
            'animaux' => $animaux,
            'nourritures' => $nourritures,
            'habitats' => $habitats,
            'repas'=>$repas,
            'createAnimalForm' => $createAnimalForm->createView(),
            'editAnimalForm' => $editAnimalForm->createView(),

        ]);
    }

    #[Route('/animal/create', name: 'createAnimal', methods: ['POST'])]
    public function createAnimal(Request $request){
        $animal= new Animal();
        $form = $this->createForm(animalFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $animal->setPrenom($form->get('prenom')->getData());
            $animal->setRace($form->get('race')->getData());
            $animal->setHabitat($form->get('habitat')->getData());
            $animal->setCreatedAt(new \DateTimeImmutable());
            $animal->setImageFile($form->get('imageFile')->getData());

            $this->entityManager->persist($animal);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_veterinaire_index');
        }
    }

    #[Route('/animal/show/{id}', name: 'showAnimal', methods: ['GET'])]
    public function showAnimal(int $id, AnimalRepository $animalRepo):Response
    {
        $animal = $animalRepo->find($id);
        if (!$animal) {
            return new JsonResponse(['status' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }
        $repas = $this->entityManager->getRepository(repas::class)->findBy(['animal' => $id], ['datetime' => 'DESC']);
        if (!$repas){
            $repas = null;
        }
        $infoAnimal = $this->entityManager->getRepository(InfoAnimal::class)->findBy
            (['animal' => $id], ['createdAt' => 'DESC']);
        return $this->render('veterinaire/showAnimal.html.twig', [
            'controller_name' => 'VeterinaireController',
            'animal' => $animal,
            'repas'=>$repas,
            'infoAnimals'=>$infoAnimal
        ]);
    }
    #[Route('/animal/update/{id}', name: 'updateAnimal', methods: ['GET','POST'])]
    public function updateAnimal(Request $request, int $id, AnimalRepository $animalRepo):Response
    {
        $animal = $animalRepo->find($id);
        if (!$animal) {
            return new JsonResponse(['status' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(EditAnimalType::class, $animal);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(isset($form['prenom'])){
                $animal->setPrenom($form['prenom']->getData());
            }else{
                $animal->setPrenom($animal->getPrenom());
            }
            if(isset($form['race'])){
                $animal->setRace($form['race']->getData());
            }else{
                $animal->setRace($animal->getRace());
            }
            if(isset($form['habitat'])){
                $animal->setHabitat($form['habitat']->getData());
            }else{
                $animal->setHabitat($animal->getHabitat());
            }
            if(isset($form['imageFile'])){
                $animal->setImageFile($form['imageFile']->getData());
            }else{
                $animal->setImageFile($animal->getImageFile());
            }
            $this->entityManager->persist($animal);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_veterinaire_index');
        }else{
            
            return $this->render('veterinaire/editAnimal.html.twig', [
                'controller_name' => 'VeterinaireController',
                'animal' => $animal,
                'editAnimalForm' => $form->createView(),
                'form'=>$form
            ]);
        }



        return new JsonResponse(['status' => 'Animal updated!'], Response::HTTP_OK);
    }



    #[Route('/animal/delete/{id}', name: 'deleteAnimal', methods: ['DELETE'])]
    public function deleteAnimal(int $id): JsonResponse
    {
        $animal = $this->entityManager->getRepository(Animal::class)->find($id);
        if (!$animal) {
            return new JsonResponse(['status' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }else{
            $this->entityManager->remove($animal);
            $this->entityManager->flush();
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        
    }



    #[Route('/animal/info/create', name: 'createInfoAnimal', methods: ['POST'])]
public function addAnimalInfo(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);
    $animalId = $data['animal'];
    $nourritureId = $data['nourriture'];
    
    // Trouver l'animal correspondant à l'id passé en paramètre
    $animal = $this->entityManager->getRepository(Animal::class)->find($animalId);
    if (!$animal) {
        return new JsonResponse(['status' => 'Animal not found'], Response::HTTP_NOT_FOUND);
    }
    
    // Créer une nouvelle instance d'InfoAnimal
    $infoAnimal = new InfoAnimal();
    
    // Définir l'animal associé
    $infoAnimal->setAnimal($animal);
    
    // Trouver la nourriture correspondant à l'id passé en paramètre
    $nourriture = $this->entityManager->getRepository(Nourriture::class)->find($nourritureId);
    if (!$nourriture) {
        return new JsonResponse(['status' => 'Nourriture not found'], Response::HTTP_NOT_FOUND);
    }
    
    // Mettre à jour les informations de l'animal
    $infoAnimal->setEtat($data['etat']);
    if (isset($data['details']) && $data['details'] !== null) {
        $infoAnimal->setDetails($data['details']);
    }
    $infoAnimal->setNourriture($nourriture);
    $infoAnimal->setGrammage($data['grammage']);
    $infoAnimal->setCreatedAt(new \DateTimeImmutable());
    
    // Enregistrer les modifications dans la base de données
    $this->entityManager->persist($infoAnimal);
    $this->entityManager->flush();
    
    return new JsonResponse(['status' => 'Animal info ' . ($infoAnimal->getId() ? 'updated' : 'created')], Response::HTTP_CREATED);
}






    #[Route('/nourriture/new', name: 'createNourriture', methods: ['POST'])]
    public function createNourriture(Request $request): JsonResponse
    {
        $nourriture = new Nourriture();
        try {
            $data = json_decode($request->getContent(), true);
            $nourriture->setNom($data['nourriture-nom']);
            $nourriture->setDescription($data['nourriture-description']);
            $this->entityManager->persist($nourriture);
            $this->entityManager->flush();
            return new JsonResponse(Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'Error creating Nourriture'], Response::HTTP_BAD_REQUEST);
        }
    }


    #[Route('/nourriture/update/{id}', name: 'updateNourriture', methods: ['PUT'])]
    public function updateNourriture(Request $request, int $id): JsonResponse
    {
        $nourriture = $this->entityManager->getRepository(Nourriture::class)->find($id);
        if (!$nourriture) {
            return new JsonResponse(['status' => 'Nourriture not found'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        if(isset($data['nourriture-nom'])) {
            $nourriture->setNom($data['nourriture-nom']);
        }else{
            $nourriture->setNom($nourriture->getNom());
        }
        if(isset($data['nourriture-description'])) {
            $nourriture->setDescription($data['nourriture-description']);
        }else{
            $nourriture->setDescription($nourriture->getDescription());
        }
        $this->entityManager->persist($nourriture);
        $this->entityManager->flush();
        return new JsonResponse(['status' => 'Nourriture updated!'], Response::HTTP_OK);
    }

    #[Route('/nourriture/delete{id}', name: 'deleteNourriture', methods: ['DELETE'])]
    public function deleteNourriture(int $id): JsonResponse
    {
        $nourriture = $this->entityManager->getRepository(Nourriture::class)->find($id);
        if (!$nourriture) {
            return new JsonResponse(['status' => 'Nourriture not found'], Response::HTTP_NOT_FOUND);
        }else{
            $this->entityManager->remove($nourriture);
            $this->entityManager->flush();
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        
    }

    #[Route('/habitat/commentaire/new', name: 'createHabitatCommentaire', methods: ['POST'])]
    public function createHabitatCommentaire(Request $request): Response
    {
        try{
        $data = json_decode($request->getContent(), true);
        $habitatId = $data['habitat'];
        $habitatCommentaire = new CommentaireHabitat();
        $habitat = $this->entityManager->getRepository(Habitat::class)->find($habitatId);
        if (!$habitat) {
            $this->addFlash('error', 'Habitat not found');
            return new JsonResponse(['status' => 'Habitat not found'], Response::HTTP_NOT_FOUND);
        }
        $habitatCommentaire->setHabitat($habitat);
        $habitatCommentaire->setCommentaire($data['commentaire']);
        $habitatCommentaire->setCreatedAt(new \DateTimeImmutable());
        $habitatCommentaire->setAuteur($this->getUser());

        
        
        $this->entityManager->persist($habitatCommentaire);
        $this->entityManager->flush();
        $this->addFlash('success', 'Commentaire ajouté avec succès');
        return new RedirectResponse($this->generateUrl('app_veterinaire_index'));
        }catch(\Exception $e){
            $this->addFlash('error', 'Erreur lors de l\'ajout du commentaire', $e->getMessage());
            return new Response($e->getMessage());
        }
    }
}