<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

use Doctrine\ODM\MongoDB\DocumentManager;

use PHPUnit\TextUI\XmlConfiguration\Groups;
use PHPUnit\Util\Json;
use DateTimeImmutable;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Form\ServiceType;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;

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
use App\Repository\RepasRepository;


use App\Entity\CommentaireHabitat;
use App\Repository\CommentaireHabitatRepository;

use App\Entity\DemandeContact;
use App\Repository\DemandeContactRepository;

use App\Form\animalFormType;
use App\Form\habitatFormType;

use App\Service\MailerService;
use App\Service\Sanitizer;

use App\Entity\Avis;
use App\Repository\AvisRepository;

use App\Entity\AdditionalImages;
use App\Form\AdditionalImageType;
use App\Repository\AdditionalImagesRepository;

use App\Document\AnimalVisit;

use App\Exception\AnimalNotFoundException;
use App\Exception\ServiceNotFound;
use App\Exception\UserNotFound;
use Symfony\Component\Validator\Constraints\Date;

use App\Service\EncryptionService;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
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
        $em=$entityManager;
        $this->dm = $dm;
        $this->serializer = $serializer;
        $this->sanitizer = $sanitizer;
    }





    #[Route('/', name: 'index', methods: ['GET'])]
public function dashboard(
    Request $request,
    AnimalRepository $animalRepo,
    HabitatRepository $habitatRepo,
    ZooRepository $zooRepo,
    HoraireRepository $horaireRepo,
    CommentaireHabitatRepository $commentaireRepo
    ): Response
{
    $animaux = $animalRepo->findAll();
    $zoos = $zooRepo->findAll();
    $horaires = $horaireRepo->findAll();
    $habitats = $habitatRepo->findAll();
    $commentaires = $commentaireRepo->findAll();
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
    public function getVisites(DocumentManager $dm): JsonResponse
    {
        try{
        $visites = $dm->getRepository(AnimalVisit::class)->findAll();
        return JsonResponse::fromJsonString($this->serializer->serialize($visites, 'json'), Response::HTTP_OK);
        }catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /*-------------------------Services ------------------------*/

    #[Route('/services/create', name: 'createService', methods: 'POST')]
    public function createService(Request $request,
    EntityManagerInterface $em, 
    Sanitizer  $sanitizer): JsonResponse
    {
        try{
            $service = new Service();
            $form = $this->createForm(ServiceType::class, $service);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $service->setNom
                    ($sanitizer->sanitizeHtml($form->get('nom')->getData()));
                $service->setDescription
                    ($sanitizer->sanitizeHtml($form->get('description')->getData()));
                $service->setCreatedAt(new DateTimeImmutable());
                $service->setImageFile($form->get('imageFile')->getData());
                $service->setZoo($em->getRepository(Zoo::class)->find(1));
                $em->persist($service);
                $em->flush();
                $this->addFlash('success', 'Service created successfully');
                return $this->redirectToRoute('app_admin_index');
            }else{
                $this->addFlash('error', 'Une erreur est survenue');
                return new RedirectResponse($this->generateUrl('app_admin_index'));
            }
        }catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue: ' . $e->getMessage());
            return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
        }
    }

    #[Route('/services/edit/{id}', name: 'editService', methods:['GET','POST'])]
    public function editService(Request $request,int $id, EntityManagerInterface $em, ServiceRepository $serviceRepo): Response
    {
    try {
        
        $service = $serviceRepo->find($id);
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
            $em->persist($service);
            $em->flush();
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
    public function delete(int $id, EntityManagerInterface $em, ServiceRepository $serviceRepo):JsonResponse
    {
        try{
        $service=$serviceRepo->find($id);
        
        if (!$service){
            throw new ServiceNotFound("Aucun service n'a été trouvé avec cet identifiant");
        }
        
        $em->remove($service);
        $em->flush();
        return new JsonResponse(Response::HTTP_OK); 
        }catch (\Exception $e) {
            $this->addFlash('error', 'An error occured');
            return new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);    
        }
    }

    /* ------------------------users------------------------ */


    #[Route('/user/delete/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function deleteUser(int $id, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {   
        try{
        $user = $userRepository->find($id);
        if (!$user) {
            throw new UserNotFound("Aucun utilisateur n'a été trouvé avec cet identifiant");    
        }
        $em->remove($user);
        $em->flush();
        return new JsonResponse(['message' => 'User deleted successfully'], Response::HTTP_OK);
        }catch (\Exception) {
            return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/user/edit/{id}', name: 'editUser', methods: ['PUT'])]
    public function editUser(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->find($id);
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
        $em->persist($user);
        $em->flush();
        return new JsonResponse(['message' => 'User updated successfully'], Response::HTTP_OK);
    }

    #[Route('/user/nonAdmins', name: 'getNonAdmins', methods: ['GET'])]
    public function getNonAdmins( UserRepository $userRepo, SerializerInterface $serializer): JsonResponse
    {
        try{
        $users = $userRepo->findNonAdmins();
        $context = ['groups' => 'user_info'];
        return  JsonResponse::fromJsonString($serializer->serialize(
            $users, 'json', $context),
            Response::HTTP_OK);
        }catch (\Exception $e){
            return new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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

    #[Route('/horaires/edit/{id}', name: 'editHoraire', methods: ['PUT'])]
    public function editHoraire(int $id, Request $request, EntityManagerInterface $em): JsonResponse
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
        $em->persist($horaire);
        $em->flush();

        $this->addFlash('success', 'Horaire updated successfully');
        return new JsonResponse(['message' => 'Horaire updated successfully'], Response::HTTP_OK);
}

/* ------------------------Habitat------------------------ */


    #[Route('/habitats/create', name: 'createHabitat', methods: 'POST')]
    public function createHabitat(Request $request, EntityManagerInterface $entityManager): Response
    {
        try{
        
        $habitat = new habitat();
        $form = $this->createForm(habitatFormType::class, $habitat);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($habitat);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_index');
        } else {
            $this->addFlash('error', 'Une erreur est survenue lors de la création de l`habitat. Veuillez remplir corretement tous les champs du formulaire et vous assurer que l`image téléchargée est au format webp.');
            return new RedirectResponse($this->generateUrl('app_admin_index'));
        }


    }catch (\Exception $e) {
        $this->addFlash('error', 'An error occured');
        return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
    }
    }


    #[Route('/habitats/update/{id}', name: 'updateHabitat', methods: ['GET', 'POST'])]
    public function updateHabitat(int $id, Request $request, HabitatRepository $habitatRepo, EntityManagerInterface $em): Response
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

            $em->persist($habitat);
            $em->flush();
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
    public function deleteHabitat(int $id, EntityManagerInterface $em):Response
    {
        $habitat=$em->getRepository(Habitat::class)->find($id);
        if (!$habitat){
            $this->addFlash('error', 'Habitat not found');
            throw $this->createNotFoundException("No habitat found for {$id} id");
        }
        $em->remove($habitat);
        $em->flush();
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
    #[Route('/infoAnimal/delete/{id}', name: 'deleteInfoAnimal', methods: ['DELETE'])]
    public function deleteInfoAnimal(int $id,InfoAnimalRepository $infoAnimalRepository, EntityManagerInterface $em): JsonResponse
    {   
        try{
        $infoAnimal = $infoAnimalRepository->find($id);
        if (!$infoAnimal) {
            return new JsonResponse(['error' => 'InfoAnimal not found'], Response::HTTP_NOT_FOUND);
        }
        $em->remove($infoAnimal);
        $em->flush();
        return new JsonResponse(Response::HTTP_OK);
        }catch (\Exception $e) {
            return new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/infoAnimal/animal/{id}', name: 'getInfoAnimalByAnimal', methods: ['GET'])]
    public function getInfoAnimalByAnimal(
        int $id,
        InfoAnimalRepository $infoAnimalRepository, 
        SerializerInterface $serializer): JsonResponse
    {
        try{
        $infoAnimal = $infoAnimalRepository->findBy(['animal' => $id]);
        $context = ['groups' => 'infoAnimal:read'];
        return JsonResponse::fromJsonString($serializer->serialize($infoAnimal, 'json', $context), Response::HTTP_OK);
        }catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/infoAnimal/search', name: 'searchInfoAnimal', methods: ['GET'])]
    public function SearchUsingDateAndOrAnimal(
        Request $request,
        InfoAnimalRepository $infoAnimalRepository,
        SerializerInterface $serializer): Response
    {
        try {
            $animal_id = $request->query->get('animal_id');
            $date = $request->query->get('date');
            $CRVS = $infoAnimalRepository->FilterByAnimalAndOrByDate($animal_id, $date);

            $SerializedCRVS = $serializer->serialize($CRVS, 'json', ['attributes' => [
                'id',
                'animal' => ['id', 'prenom'],
                'createdAt',
                'auteur' => ['id','email'],
            ]]);

            return new JsonResponse($SerializedCRVS, Response::HTTP_OK, [], true);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
        
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'An error occurred',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
         else {
            $this->addFlash('error', 'Une erreur est survenue lors de la création de l`habitat. Veuillez remplir corretement tous les champs du formulaire et vous assurer que l`image téléchargée est au format webp.');
            return new RedirectResponse($this->generateUrl('app_admin_index'));
        }
        }catch (\Exception $e) {
            $this->addFlash('error', 'An error occured');
            return new Response('Une erreur est survenue : ' . $e->getMessage(), 500);
        }
    }
    #[Route('/animal/show/{id}', name: 'showAnimal', methods: ['GET', 'POST'])]
    public function showAnimal(
        int $id, 
        AnimalRepository $animalRepo, 
        EntityManagerInterface $em,
        InfoAnimalRepository $infoAnimalRepository,
        RepasRepository $repasRepository,
        AdditionalImagesRepository $additionalImagesRepository,
        Request $request
        ):Response
    {
        $animal = $animalRepo->find($id);
        if (!$animal) {
            throw new AnimalNotFoundException("Aucun animal n'a été trouvé avec cet identifiant");
        }
        $repas = $repasRepository->findBy(['animal' => $id], ['datetime' => 'DESC']);
        if (!$repas){
            $repas = null;
        }
        $infoAnimal = $infoAnimalRepository->findBy
            (['animal' => $id], ['createdAt' => 'DESC']);
        if (!$infoAnimal){
            $infoAnimal = null;
        }

        $animalImages =  $additionalImagesRepository->findBy(['animal' => $id], ['createdAt' => 'DESC']);  
        if (!$animalImages){
            $animalImages = null;
        }
        $form = $this->createForm(AdditionalImageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
            $additionalImage = $form->getData();
            if(
                imagecreatefromwebp($additionalImage->getImageFile()) === false
            ){
                throw new \Exception('Le fichier téléchargé n\'est pas une image au format webp');

            }
            
            $additionalImage->setAnimal($animal);
            $additionalImage->setCreatedAt(new DateTimeImmutable());
            $em->persist($additionalImage);
            $em->flush();
            $this->addFlash('success', 'Image ajoutée avec succès');
            return $this->redirectToRoute('app_admin_showAnimal', ['id' => $id]);
            }catch (\Exception $e) {
                throw new \Exception('Une erreur est survenue. Merci de réessayer plus tard.');
            }
        }
        

        return $this->render('admin/showAnimal.html.twig', [
            'controller_name' => 'AdminController',
            'animal' => $animal,
            'repas'=>$repas,
            'infoAnimals'=>$infoAnimal,
            'form' => $form->createView(),
            'animalImages' => $animalImages,

        ]);
    }
    
    #[Route('/animal/update/{id}', name: 'updateAnimal', methods: ['GET','POST'])]
    public function updateAnimal(Request $request, int $id, AnimalRepository $animalRepo, EntityManagerInterface $em):Response
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
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute('app_admin_index');
        }else{
            
            return $this->render('admin/editAnimal.html.twig', [
                'controller_name' => 'AdminController',
                'animal' => $animal,
                'editAnimalForm' => $form->createView(),
                'form'=>$form
            ]);
        }
    }

    #[Route('/animal/delete/{id}', name: 'deleteAnimal', methods: ['DELETE'])]
    public function deleteAnimal(int $id, 
    EntityManagerInterface $entityManager,
    DocumentManager $docuManager): JsonResponse
    {   
        try{
            $animal = $entityManager->getRepository(Animal::class)->find($id);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Aucun animal n\'a été trouvé avec cet identifiant');
            throw $this->createNotFoundException("No animal found for {$id} id");
        }
        try{
            $document=$docuManager->getRepository(AnimalVisit::class)->findOneBy(['animalId' => $id]);
            if($document){
            $docuManager->remove($document);
            $docuManager->flush();
            }         
            $entityManager->remove($animal);
            $entityManager->flush();
            $this->addFlash('success', 'Animal deleted successfully');
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue pendant la suppression de l\'animal. Si le problème perisiste, veuillez contacter l\'administrateur du site.');
            return new JsonResponse('Une erreur est survenue : ' . $e->getMessage(), 500);
        }
        
    }

    #[Route('/demande/repondre/{id}', name: 'repondre_demande', methods:['POST'])]
    public function repondreDemande(Request $request, 
    MailerService $mailerService, 
    DemandeContactRepository $demandeRepo, 
    EntityManagerInterface $em,
    EncryptionService $EncryptionService
    ): Response
    {
    try {
    
        $data = json_decode($request->getContent(), true);
        $text = $data['response'];
        $id = $request->attributes->get('id');
        $destinataire = $EncryptionService->decrypt($demandeRepo->find($id)->getMail()); // Décrypter l'email du destinataire dans la base de données
        $mailerService->sendResponseMail($destinataire, $text);
        $demande=$demandeRepo->find($request->attributes->get('id'));
        $demande->setAnsweredAt(new DateTimeImmutable());
        $demande->setAnswered(true);
        $em->persist($demande);
        $em->flush();
    } catch (\Exception $e) {
        $this->addFlash('error', 'Une erreur est survenue: ' . $e->getMessage());
    }
    return new RedirectResponse($this->generateUrl('app_admin_index'));
    }

    #[Route('/demande/delete/{id}', name: 'delete_demande', methods:['DELETE'])]
    public function deleteDemande(Request $request, int $id, DemandeContactRepository $demandeRepo, EntiTyManagerInterface $em): Jsonresponse
    {   
        try{
        $demande=$demandeRepo->find($request->attributes->get('id'));
        if (!$demande){
            $this->addFlash('error', 'Demande not found');
            throw $this->createNotFoundException("No demande found for {$id} id");
        }
        $em->remove($demande);
        $em->flush();
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
    public function validerAvis(int $id, EntityManagerInterface $em, AvisRepository $avisRepo): JsonResponse
    {   
        try{
        $avis = $avisRepo->find($id);
        if (!$avis) {
            return new JsonResponse(['error' => 'Avis not found'], Response::HTTP_NOT_FOUND);
        }
        $avis->setValidation(true);
        $em->persist($avis);
        $em->flush();
        return new JsonResponse( Response::HTTP_OK);
    }catch(\Exception $e){
        return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    }

    #[Route('/avis/delete/{id}', name: 'deleteAvis', methods: ['DELETE'])]
    public function deleteAvis(int $id,EntityManagerInterface $em, AvisRepository $avisRepo): JsonResponse
    {
        $avis = $avisRepo->find($id);
        if (!$avis) {
            return new JsonResponse(['error' => 'Avis not found'], Response::HTTP_NOT_FOUND);
        }
        $em->remove($avis);
        $em->flush();
        return new JsonResponse(['message' => 'Avis deleted successfully'], Response::HTTP_OK);
    }

    #[Route('/comment/delete/{id}', name: 'deleteCommentaire', methods: ['DELETE'])] 
    public function deleteCommentaireHabitat(int $id, CommentaireHabitatRepository $commRepo, EntityManagerInterface $em): JsonResponse
    {   try{
        if(!$this->isGranted('ROLE_ADMIN')){
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $commentaire = $commRepo->find($id);
        if (!$commentaire) {
            return new JsonResponse(['error' => 'Commentaire not found'], Response::HTTP_NOT_FOUND);
        }
        $em->remove($commentaire);
        $em->flush();
        $this->addFlash('success', 'Commentaire deleted successfully');
        return new JsonResponse(['message' => 'Commentaire deleted successfully'], Response::HTTP_OK);
    }catch(\Exception $e){
        $this->addFlash('error', 'An error occured');
        return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    }

    #[Route('/image/delete/{id}', name: 'delete_image', methods: ['DELETE'])]
    public function deleteImage(int $id, EntityManagerInterface $em, AdditionalImagesRepository $additionalImagesRepository): JsonResponse
    {
        try{
        $image = $additionalImagesRepository->find($id);
        if (!$image) {
            return new JsonResponse(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }
        $em->remove($image);
        $em->flush();
        return new JsonResponse(['message' => 'Image deleted successfully'], Response::HTTP_OK);
        }catch(\Exception ){
            return new JsonResponse(['error' => 'An error occured'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
}
    
}