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

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Form\EditAnimalType;
use App\Entity\InfoAnimal;
use App\Repository\InfoAnimalRepository;
use App\Entity\Repas;

use App\Entity\CommentaireHabitat;
use App\Entity\DemandeContact;

use App\Form\animalFormType;
use App\Form\habitatFormType;
use App\Form\ServiceType;
use App\Service\MailerService;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\AnimalVisit;
use App\Entity\Avis;
use App\Repository\AvisRepository;
use PHPUnit\TextUI\XmlConfiguration\Groups;
use PHPUnit\Util\Json;
use App\Service\Sanitizer;



use App\Exception\AnimalNotFoundException;
use App\Exception\ServiceNotFound;
use App\Exception\UserNotFound;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private HoraireRepository  $horaireRepository,
        private DocumentManager $dm,
        private Sanitizer $sanitizer

        )
    {
        $this->entityManager=$entityManager;
        $this->dm = $dm;
        $this->serializer = $serializer;
        $this->sanitizer = $sanitizer;
    }





    #[Route('/', name: 'index', methods: ['GET'])]
public function dashboard(Request $request): Response
{
    $animaux = $this->entityManager->getRepository(Animal::class)->findAll();
    $zoos = $this->entityManager->getRepository(Zoo::class)->findAll();
    $horaires = $this->entityManager->getRepository(Horaire::class)->findAll();
    $habitats = $this->entityManager->getRepository(Habitat::class)->findAll();
    $commentaires = $this->entityManager->getRepository(CommentaireHabitat::class)->findAll();
    $createAnimalForm = $this->createForm(AnimalFormType::class);
    $createHabitatForm = $this->createForm(HabitatFormType::class);
    $serviceForm = $this->createForm(ServiceType::class);


    return $this->render('admin/dashboard.html.twig', [
        'controller_name' => 'AdminController',
        'zoos' => $zoos,
        'horaires' => $horaires,
        'habitats' => $habitats,
        'animaux' => $animaux,
        'commentaires' => $commentaires,
        'createAnimalForm' => $createAnimalForm->createView(),
        'createHabitatForm' => $createHabitatForm->createView(),
        'serviceForm' => $serviceForm->createView(),

    ]);
}



    #[Route('/visites/all', name: 'getVisites', methods: ['GET'])]
    public function getVisites(): JsonResponse
    {
        try{
        $visites = $this->dm->getRepository(AnimalVisit::class)->findAll();
        return JsonResponse::fromJsonString($this->serializer->serialize($visites, 'json'), Response::HTTP_OK);
        }catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /*-------------------------Services ------------------------*/

    #[Route('/services/create', name: 'createService', methods: 'POST')]
    public function createService(Request $request): Response
    {
        try{
            $service = new Service();
            $form = $this->createForm(ServiceType::class, $service);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $service->setNom
                ($this->sanitizer->sanitizeHtml($form->get('nom')->getData()));
                $service->setDescription
                ($this->sanitizer->sanitizeHtml($form->get('description')->getData()));
                $service->setCreatedAt(new \DateTimeImmutable());
                $service->setImageFile($form->get('imageFile')->getData());
                $service->setZoo($this->entityManager->getRepository(Zoo::class)->find(1));
                $this->entityManager->persist($service);
                $this->entityManager->flush();
                $this->addFlash('success', 'Service created successfully');
                return $this->redirectToRoute('app_admin_index');
            }else{
                $this->addFlash('error', 'Une erreur est survenue', 500);
                return new RedirectResponse($this->generateUrl('app_admin_index'));
            }
        }catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue: ' . $e->getMessage());
            return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
        }
    }

    #[Route('/services/edit/{id}', name: 'editService', methods:['GET','POST'])]
    public function editService(Request $request,int $id): Response
    {
    try {
        
        $service = $this->entityManager->getRepository(Service::class)->find($id);
        if (!$service) {
            throw new ServiceNotFound("Aucun service n'a été trouvé avec cet identifiant");
        }
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if(isset($form['nom'])){
                $service->setNom($this->sanitizer->sanitizeHtml($form['nom']->getData()));
            }else{
                $service->setNom($service->getNom());
            }
            if(isset($form['description'])){
                $service->setDescription($this->sanitizer->sanitizeHtml($form['description']->getData()));
            }else{
                $service->setDescription($service->getDescription());
            }
            if(isset($form['imageFile'])){
                $service->setImageFile($form['imageFile']->getData());
            }else{
                $service->setImageFile($service->getImageFile());
            }
            $this->entityManager->persist($service);
            $this->entityManager->flush();
            $this->addFlash('success', 'Service updated successfully');
            return $this->redirectToRoute('app_admin_index');
        }else{
            return $this->render('admin/editService.html.twig', [
                'controller_name' => 'AdminController',
                'service' => $service,
                'editServiceForm' => $form->createView(),
                'form'=>$form
            ]);
        }
    } catch (\Exception $e) {
        $this->addFlash('error', 'Une erreur est survenue: ' . $e->getMessage());
        return $this->redirectToRoute('app_admin_index');
        }
    }

    #[Route('/services/delete/{id}',name: 'deleteService', methods: 'DELETE')]
    public function delete(int $id):JsonResponse
    {
        try{
        $service=$this->entityManager->getRepository(Service::class)->find($id);
        
        if (!$service){
            throw new ServiceNotFound("Aucun service n'a été trouvé avec cet identifiant");
        }
        
        $this->entityManager->remove($service);
        $this->entityManager->flush();
        return new JsonResponse(Response::HTTP_OK); 
        }catch (\Exception $e) {
            $this->addFlash('error', 'An error occured');
            return new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);    
        }
    }

    /* ------------------------users------------------------ */


    #[Route('/user/delete/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function deleteUser(int $id, UserRepository $userRepository): JsonResponse
    {   
        try{
        $user = $userRepository->find($id);
        if (!$user) {
            throw new UserNotFound("Aucun utilisateur n'a été trouvé avec cet identifiant");    
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'User deleted successfully'], Response::HTTP_OK);
        }catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/user/edit/{id}', name: 'editUser', methods: ['PUT'])]
    public function editUser(int $id, Request $request): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw new UserNotFound("Aucun utilisateur n'a été trouvé avec cet identifiant");
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

    #[Route('/user/nonAdmins', name: 'getNonAdmins', methods: ['GET'])]
    public function getNonAdmins(): JsonResponse
    {   
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $context = ['groups' => 'user_info'];
        $nonAdmins = [];
        foreach ($users as $user) {
            if (!in_array('ROLE_ADMIN', $user->getRoles())) {
                $nonAdmins[] = $user;
            }
        }
        return JsonResponse::fromJsonString($this->serializer->serialize(
            $nonAdmins, 'json', $context),
            Response::HTTP_OK);
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
    public function showInfoAnimal(int $id, InfoAnimalRepository $infoAnimalRepository): Response
    {
        try{
        $infoAnimal = $infoAnimalRepository->find($id);
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
        }catch (\Exception $e) {
            throw new \Exception('An error occured: ' . $e->getMessage());
        }
    }
    #[ROute('/infoAnimal/delete/{id}', name: 'deleteInfoAnimal', methods: ['DELETE'])]
    public function deleteInfoAnimal(int $id,InfoAnimalRepository $infoAnimalRepository): JsonResponse
    {   
        try{
        $infoAnimal = $infoAnimalRepository->find($id);
        if (!$infoAnimal) {
            return new JsonResponse(['error' => 'InfoAnimal not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($infoAnimal);
        $this->entityManager->flush();
        return new JsonResponse(Response::HTTP_OK);
        }catch (\Exception $e) {
            return new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
    /* ------------------------Animal------------------------ */
    
    #[Route('/animal/all', name: 'getAnimals', methods: ['GET'])]
    public function getAnimals(AnimalRepository $animalRepository): JsonResponse
    {
        try{
        $animals = $animalRepository->findAll();
        $context = ['groups' => 'animal:read'];
        return JsonResponse::fromJsonString($this->serializer->serialize(
            $animals, 'json', $context),
            Response::HTTP_OK);
        
        }catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occured', $e->getMessage() ],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/animal/create', name: 'createAnimal', methods: ['POST'])]
    public function createAnimal(Request $request, 
    EntityManagerInterface $entityManager, 
    DocumentManager $dm): Response{
        try{
            $animal= new Animal();
            $form = $this->createForm(animalFormType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $animal->setPrenom($form->get('prenom')->getData());
                $animal->setRace($form->get('race')->getData());
                $animal->setHabitat($form->get('habitat')->getData());
                $animal->setCreatedAt(new DateTimeImmutable());
                $animal->setImageFile($form->get('imageFile')->getData());
                
                $entityManager->persist($animal);
                $entityManager->flush();
                
                $visit = new AnimalVisit();
                $visit->setAnimalId($animal->getId());
                $visit->setAnimalName($animal->getPrenom());
                $visit->setVisits(0);
                $dm->persist($visit);
                $dm->flush();
                $this->addFlash('success', 'Animal created successfully');
                return $this->redirectToRoute('app_admin_index');
            }
        }catch (\Exception $e) {
            $this->addFlash('error', 'An error occured');
            return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
        }
    }
    #[Route('/animal/show/{id}', name: 'showAnimal', methods: ['GET'])]
    public function showAnimal(int $id, AnimalRepository $animalRepo):Response
    {
        $animal = $animalRepo->find($id);
        if (!$animal) {
            throw new AnimalNotFoundException("Aucun animal n'a été trouvé avec cet identifiant");
        }
        $repas = $this->entityManager->getRepository(repas::class)->findBy(['animal' => $id], ['datetime' => 'DESC']);
        if (!$repas){
            $repas = null;
        }
        $infoAnimal = $this->entityManager->getRepository(InfoAnimal::class)->findBy
            (['animal' => $id], ['createdAt' => 'DESC']);
        return $this->render('admin/showAnimal.html.twig', [
            'controller_name' => 'AdminController',
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
            throw new AnimalNotFoundException("Aucun animal n'a été trouvé avec cet identifiant");
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
            throw new AnimalNotFoundException("Aucun animal n'a été trouvé avec cet identifiant");
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
        $this->entityManager->persist($demande);
        $this->entityManager->flush();
    } catch (\Exception $e) {
        $this->addFlash('error', 'Une erreur est survenue: ' . $e->getMessage());
    }
    return new RedirectResponse($this->generateUrl('app_employe_index'));
    }

    #[Route('/demande/delete/{id}', name: 'delete_demande', methods:['DELETE'])]
    public function deleteDemande(Request $request, int $id): Jsonresponse
    {   
        try{
        $demande=$this->entityManager->getRepository(DemandeContact::class)->find($request->attributes->get('id'));
        if (!$demande){
            $this->addFlash('error', 'Demande not found');
            throw $this->createNotFoundException("No demande found for {$id} id");
        }
        $this->entityManager->remove($demande);
        $this->entityManager->flush();
        return new JsonResponse('Demande deleted successfully', 200);
    }catch (\Exception $e) {
        $this->addFlash('error', 'Une erreur est survenue pendant la suppression de la demande de contact. Si le problème perisiste, veuillez contacter l\'administrateur du site.');
        return new JsonResponse('Une erreur est survenue : ' . $e->getMessage(), 500);
    }
    }


    #[Route('/avis/getNonValidated', name: 'getAllAvis', methods: ['GET'])]
    public function getNonValidated(AvisRepository $avisRepo): JsonResponse
    {   
        try{
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $avis = $avisRepo->findBy(
            ['validation' => false]
        );
        $context = ['groups' => 'avis:read'];
        return JsonResponse::fromJsonString($this->serializer->serialize($avis, 'json',$context), Response::HTTP_OK);
        }   catch(\Exception $e){
            return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
    }

    #[Route('/avis/valider/{id}', name: 'validateAvis', methods: ['POST'])]
    public function validerAvis(int $id): JsonResponse
    {   
        try{
        $avis = $this->entityManager->getRepository(Avis::class)->find($id);
        if (!$avis) {
            return new JsonResponse(['error' => 'Avis not found'], Response::HTTP_NOT_FOUND);
        }
        $avis->setValidation(true);
        $this->entityManager->persist($avis);
        $this->entityManager->flush();
        return new JsonResponse( Response::HTTP_OK);
    }catch(\Exception $e){
        return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    }

    #[Route('/avis/delete/{id}', name: 'deleteAvis', methods: ['DELETE'])]
    public function deleteAvis(int $id): JsonResponse
    {
        $avis = $this->entityManager->getRepository(Avis::class)->find($id);
        if (!$avis) {
            return new JsonResponse(['error' => 'Avis not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($avis);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'Avis deleted successfully'], Response::HTTP_OK);
    }

    #[Route('/commentaires/delete/{id}', name: 'deleteCommentaire', methods: ['DELETE'])] 
    public function deleteCommentaireHabitat(int $id): JsonResponse
    {   try{
        if (!$this->isGranted('ROLE_AUTHENTICATED_FULLY')) {
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }   
        $commentaire = $this->entityManager->getRepository(CommentaireHabitat::class)->find($id);
        if (!$commentaire) {
            return new JsonResponse(['error' => 'Commentaire not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($commentaire);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'Commentaire deleted successfully'], Response::HTTP_OK);
    }catch(\Exception $e){
        return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
    } 
}
    
}