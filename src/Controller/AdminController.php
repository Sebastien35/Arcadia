<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use DateTimeImmutable;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Zoo;
use App\Repository\ZooRepository;
use App\Entity\Horaire;
use App\Repository\HoraireRepository;
use App\Entity\Habitat;
use App\Repository\HabitatRepository;
use App\Form\habitatFormType;
use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Form\EditAnimalType;
use App\Entity\InfoAnimal;
use App\Form\animalFormType;
use App\Entity\CommentaireHabitat;
use App\Entity\DemandeContact;

use App\Service\MailerService;


#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{

    
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private HoraireRepository  $horaireRepository
        )
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function dashboard(): Response
    {
        $services = $this->entityManager->getRepository(Service::class)->findAll();
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $zoos = $this->entityManager->getRepository(Zoo::class)->findAll();
        $horaires = $this->entityManager->getRepository(Horaire::class)->findAll();
        $habitats = $this->entityManager->getRepository(Habitat::class)->findAll();
        $animaux = $this->entityManager->getRepository(Animal::class)->findAll();
        $infoAnimals = $this->entityManager->getRepository(infoAnimal::class)->findAll();
        $commentaires= $this->entityManager->getRepository(CommentaireHabitat::class)->findAll();
        $demandes = $this->entityManager->getRepository(DemandeContact::class)->findAll();
        $createAnimalForm=$this->createForm(animalFormType::class);
        $createHabitatForm=$this->createForm(habitatFormType::class);

        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'services'=>$services,
            'users'=>$users,
            'zoos'=>$zoos,
            'horaires'=>$horaires,
            'habitats'=>$habitats,
            'animaux'=>$animaux,
            'infoAnimals'=>$infoAnimals,
            'createAnimalForm'=>$createAnimalForm->createView(),
            'createHabitatForm'=>$createHabitatForm->createView(),
            'demandes'=>$demandes,
            'commentaires'=>$commentaires



        ]);
    }

    /*-------------------------Services ------------------------*/


    #[Route('/services', name: 'servicesAdmin', methods: ['GET'])]
    public function indexServices(ServiceRepository $servRepo): Response
    {
        $services = $servRepo->findAll();
        return $this->render('admin/services.html.twig', [
            'controller_name' => 'AdminController',
            'services'=>$services
        ]);
    }

    #[Route('/services/create', name: 'createService', methods: 'POST')]
    public function createService(Request $request): JsonResponse
    {
        try{
            $service = $this->serializer->deserialize($request->getContent(), Service::class, 'json');
            $service->setCreatedAt(new DateTimeImmutable());

            $this->entityManager->persist($service);
            $this->entityManager->flush();
            $this->addFlash('success', 'Service created successfully');
            return new JsonResponse(['message' => 'Service created successfully'], Response::HTTP_CREATED);

        }
        catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/services/edit/{id}', name: 'edit_service', methods:['PUT'])]
    public function editService(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $service = $this->entityManager->getRepository(Service::class)->find($id);
        if(isset($data['nom']) && !empty($data['nom'])){
            $service->setNom($data['nom']);
        }else{
            $service->setNom($service->getNom());
        }
        if(isset($data['description']) && !empty($data['description'])){
            $service->setDescription($data['description']);
        }else{
            $service->setDescription($service->getDescription());
        }
        $this->entityManager->persist($service);
        $this->entityManager->flush();
        $this->addFlash('success', 'Service updated!');
        return new JsonResponse(['status' => 'Service updated!'], Response::HTTP_OK);
    }

    #[Route('/services/delete/{id}',name: 'deleteService', methods: 'DELETE')]
    public function delete(int $id):Response
    {
        try{
        $service=$this->entityManager->getRepository(Service::class)->find($id);
        
        if (!$service){
            $this->addFlash('error', 'Service not found');
            throw $this->createNotFoundException("No service found for {$id} id");
        }
        
        $this->entityManager->remove($service);
        $this->entityManager->flush();
        $this->addFlash('success', 'Service deleted successfully');
        $this->addFlash('Success', 'Le service a été supprimé avec succès!');
        return new Response('Service deleted successfully', 200);
        }catch (\Exception $e) {
            $this->addFlash('error', 'An error occured');
            return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
        }
    }

    /* ------------------------users------------------------ */

    #[Route('/users', name: 'userAdmin', methods: ['GET'])]
    public function indexUser(UserRepository $userRepo, ZooRepository $ZooRepo): Response
    {
        $users=$userRepo->findAll();
        $zoos=$ZooRepo->findAll();
        
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'users'=>$users,
            'zoos'=>$zoos
            ,
        ]);
    }

    #[Route('/user/delete/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function deleteUser(int $id): Response
    {
        $user=$this->entityManager->getRepository(User::class)->find($id);
        if(!$user){
            $this->addFlash('error', 'User not found');
            throw $this->createNotFoundException('No user found for id '.$id);
        }else{
            try{
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'User deleted successfully');
            return new Response('User deleted successfully', 200);
            }catch (\Exception $e) {
                $this->addFlash('error', 'An error occured');
                return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
            }
        }
    }

    

    #[Route('/user/edit/{id}', name: 'editUser', methods: ['PUT'])]
    public function editUser(int $id, Request $request): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $data=json_decode($request->getContent(), true);
        if (isset($data['email']) && !empty($data['email'])) {
            $user->setEmail($data['email']);
        }else{
            $user->setEmail($user->getEmail());
        }
        if(isset($data['roles'])) {
            $user->setRoles($data['roles']);
        }else{
            $user->setRoles($user->getRoles());
        }
        if(isset($data['password'])) {
            $user->setPassword($data['password']);
        }else{
            $user->setPassword($user->getPassword());
        }
        $user->setUpdatedAt(new DateTimeImmutable());
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'User updated successfully'], Response::HTTP_OK);
    }



    /* ------------------------Horaires------------------------ */

    #[Route('/horaires', name: 'horairesAdmin', methods: ['GET'])]
    public function indexHoraires(HoraireRepository $horaireRepo): Response
    {
        $horaires = $horaireRepo->findAll();
        return $this->render('admin/horaires.html.twig', [
            'controller_name' => 'AdminController',
            'horaires'=>$horaires
        ]);
    }

    #[Route('/horaires/new', name: 'newHoraire', methods: ['POST'])]
    public function newHoraire(Request $request): Response
    {
    try {
        $id_jour = $request->request->get('id__jour');
        $horaire = $this->entityManager->getRepository(Horaire::class)->find($id_jour);

        if (!$horaire) {
            // Si l'entité n'existe pas, créez une nouvelle instance
            $horaire = new Horaire();
        }

        // Conversion des chaînes de date en objets DateTime
        $h_ouverture = new \DateTime($request->request->get('HOuverture'));
        $h_fermeture = new \DateTime($request->request->get('HFermeture'));

        // Attribution des valeurs aux propriétés de l'objet Horaire
        $horaire->setIdJour($id_jour);
        $horaire->setHOuverture($h_ouverture);
        $horaire->setHFermeture($h_fermeture);

        // Validation des données avant la persistance (ajoutez des validations supplémentaires si nécessaire)

        // Persistance et flush avec gestion des exceptions
        $this->entityManager->persist($horaire);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_horairesAdmin');
            } catch (\Exception $e) {
        // Gestion des exceptions (log, affichage d'un message d'erreur, etc.)
        return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
        }
        }

    #[Route('/horaires/edit/{id}', name: 'editHoraire', methods: ['PUT'])]
    public function editHoraire(int $id, Request $request): JsonResponse
    {
        error_log(print_r($request->getContent(), true)); // Debug
        $horaire = $this->horaireRepository->find($id);
    
        if (!$horaire) {
            return new JsonResponse(['error' => 'Horaire not found'], Response::HTTP_NOT_FOUND);
        }
    
        // Deserialize JSON data into Horaire object
        $horaire = $this->serializer->deserialize(
            $request->getContent(),
            Horaire::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $horaire]
        );
        $requestDecoded=Json_decode($request->getContent(), true);
        $horaire->setOuvert($requestDecoded['ouvert']);

        $HeureOuverture = date_create_from_format('H:i', $requestDecoded['ouverture']);
        $HeureFermeture = date_create_from_format('H:i', $requestDecoded['fermeture']);
        $horaire->setHOuverture($HeureOuverture);
        $horaire->setHFermeture($HeureFermeture);
        $this->entityManager->persist($horaire);
        $this->entityManager->flush();

        $this->addFlash('success', 'Horaire updated successfully');
        return new JsonResponse(['message' => 'Horaire updated successfully'], Response::HTTP_OK);
}

/* ------------------------Habitat------------------------ */

    #[Route('/habitats', name: 'habitatsIndex', methods: ['GET'])]
    public function indexHabitats(HabitatRepository $habitatRepo): Response
    {
    $habitats = $habitatRepo->findAll();
    $createForm = $this->createForm(habitatFormType::class);
    return $this->render('admin/habitats.html.twig', [
        'controller_name' => 'AdminController',
        'habitats'=>$habitats,
        'createForm' => $createForm->createView(),

    ]);
    }

    #[Route('/habitats/create', name: 'createHabitat', methods: 'POST')]
    public function createHabitat(Request $request): Response
    {
        try{
        $habitat = new habitat();
        $form = $this->createForm(habitatFormType::class, $habitat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($habitat);
            $this->entityManager->flush();
            $this->addFlash('success', 'Habitat created successfully');
            return $this->redirectToRoute('app_admin_index');
            
        }
    }catch (\Exception $e) {
        $this->addFlash('error', 'An error occured');
        return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
    }
    }


    #[Route('/habitats/update/{id}', name: 'updateHabitat', methods: ['GET', 'POST'])]
    public function updateHabitat(int $id, Request $request, HabitatRepository $habitatRepo): Response
    {
        $habitat = $habitatRepo->find($id);

        if (!$habitat) {
            throw $this->createNotFoundException("No habitat found for {$id} id");
        }
        $form = $this->createForm(habitatFormType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            var_dump('form submitted & valid');
            //dd($form->getData()); // Debug
            $habitat->setNom($form->get('nom')->getData());
            $habitat->setDescription($form->get('description')->getData());
            $habitat->setImageFile($form->get('imageFile')->getData());

            $this->entityManager->persist($habitat);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_admin_index');

        }else{
            return $this->render('admin/update_habitat.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
            'habitat' => $habitat
            ]);
        }
    }

    #[Route('/habitats/delete/{id}',name: 'deleteHabitat', methods: 'DELETE')]
    public function deleteHabitat(int $id):Response
    {
        $habitat=$this->entityManager->getRepository(Habitat::class)->find($id);
        if (!$habitat){
            $this->addFlash('error', 'Habitat not found');
            throw $this->createNotFoundException("No habitat found for {$id} id");
        }
        $this->entityManager->remove($habitat);
        $this->entityManager->flush();
        $this->addFlash('success', 'Habitat deleted successfully');
        return new Response('Habitat deleted successfully', 200);
    }



    /* ------------------------infoAnimal------------------------ */
    #[Route('/infoAnimal/show/{id}',name: 'showInfoAnimal', methods: ['GET'])]
    public function showInfoAnimal(int $id){
        $infoAnimal = $this->entityManager->getRepository(InfoAnimal::class)->find($id);
        if (!$infoAnimal){
            throw $this->createNotFoundException(
                'No infoAnimal found for id '.$id
            );
        }else{
            return $this->render('admin/showInfoAnimal.html.twig', [
                'controller_name' => 'AdminController',
                'infoAnimal'=>$infoAnimal
            ]);
        }
    }
    




    /* ------------------------Animal------------------------ */
    
    #[Route('/animal/create', name: 'createAnimal', methods: ['POST'])]
    public function createAnimal(Request $request){
        try{
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
                $this->addFlash('success', 'Animal created successfully');
                return $this->redirectToRoute('app_admin_index');
            }
        }catch (\Exception $e) {
            $this->addFlash('error', 'An error occured');
            return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
        }
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
            return $this->redirectToRoute('app_admin_index');
        }else{
            
            return $this->render('admin/editAnimal.html.twig', [
                'controller_name' => 'AdminController',
                'animal' => $animal,
                'editAnimalForm' => $form->createView(),
                'form'=>$form
            ]);
        }
        $this->addFlash('success', 'Animal updated successfully');
        return new JsonResponse(['status' => 'Animal updated!'], Response::HTTP_OK);
    }

    #[Route('/animal/delete/{id}', name: 'deleteAnimal', methods: ['DELETE'])]
    public function deleteAnimal(int $id): JsonResponse
    {
        $animal = $this->entityManager->getRepository(Animal::class)->find($id);
        if (!$animal) {
            $this->addFlash('error', 'Animal not found');
            return new JsonResponse(['status' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }else{
            $this->entityManager->remove($animal);
            $this->entityManager->flush();
            $this->addFlash('success', 'Animal deleted successfully');
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        
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
    
}