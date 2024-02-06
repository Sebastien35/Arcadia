<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Zoo;
use App\Repository\ZooRepository;
use App\Entity\Horaire;
use App\Repository\HoraireRepository;
use DateTime;
use DateTimeImmutable;



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
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/services', name: 'servicesAdmin', methods: ['GET'])]
    public function indexServices(ServiceRepository $servRepo): Response
    {
        $services = $servRepo->findAll();
        return $this->render('admin/services.html.twig', [
            'controller_name' => 'AdminController',
            'services'=>$services
        ]);
    }

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

    #[Route('/users/delete/{id}', name: 'deleteUser', methods: ['delete'])]
    public function deleteUser(int $id): Response
    {
        $user=$this->entityManager->getRepository(User::class)->find($id);
        if(!$user){
            throw $this->createNotFoundException('No user found for id '.$id);
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_admin_userAdmin');
    }

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
            $request->getContent(
                
            ),
            Horaire::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $horaire]
        );
        $requestDecoded=Json_decode($request->getContent(), true);
        $horaire->setOuvert($requestDecoded['ouvert']);
        //dd($requestDecoded);

        $HeureOuverture = date_create_from_format('H:i', $requestDecoded['ouverture']);
        $HeureFermeture = date_create_from_format('H:i', $requestDecoded['fermeture']);
        $horaire->setHOuverture($HeureOuverture);
        $horaire->setHFermeture($HeureFermeture);
       // dd($ouvert); // Debug

       // $horaire->setOuvert($request->get('ouvert'));
 
       // dd($request->get('h_ouverture'), $request->get('h_fermeture')); // Debug
        // Persist changes to the database
        $this->entityManager->persist($horaire);
        $this->entityManager->flush();
    
        return new JsonResponse(['message' => 'Horaire updated successfully'], Response::HTTP_OK);
}


    
    // Pour tester
    //#[Route('/horaires/show/{id}',name: 'showHoraire', methods: ['GET'])]
    //public function showHoraire(int $id):Response
    //{
    //
    //    $horaire = $this->entityManager->getRepository(Horaire::class)->find($id);
    //    dd($id, $horaire);
    //    if (!$horaire){
    //        throw $this->createNotFoundException(
    //            'No horaire found for id '.$id
    //        );
     //   }
    //    return $this->render('admin/showHoraire.html.twig', [
    //        'controller_name' => 'AdminController',
    //        'horaire'=>$horaire //
    //  ]);
    // }

    #[Route('/services/create', name: 'createService', methods: 'POST')]
    public function createService(Request $request): JsonResponse
    {
        try{
            $service = $this->serializer->deserialize($request->getContent(), Service::class, 'json');
            $service->setCreatedAt(new DateTimeImmutable());

            $this->entityManager->persist($service);
            $this->entityManager->flush();
            return new JsonResponse(['message' => 'Service created successfully'], Response::HTTP_CREATED);

        }
        catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    #[Route('/services/update/{id}', name: 'updateService', methods: ['PUT'])]
    public function editService(int $id, Request $request): JsonResponse
    {
        try {
            // Find the service by its ID
            $service=$this->entityManager->getRepository(Service::class)->find($id);

            try {
                // If service not found, return 404
                if (!$service) {
                    throw $this->createNotFoundException("No service found for {$id} id");
                }
                
                // Parse the JSON data from the request body
                $data = json_decode($request->getContent(), true);

                // Update the service entity with the new data
                $service->setNom($data['nom'] ?? $service->getNom());
                $service->setDescription($data['description'] ?? $service->getDescription());
                $service->setUpdatedAt(new DateTimeImmutable());

                // Persist the changes to the database
                $this->entityManager->flush();

                // Return a success response
                return new JsonResponse(['message' => 'Service updated successfully'], Response::HTTP_OK);
            } catch (\Exception $e) {
                // Handle the exception here
                // You can log the error, display a custom error message, or perform any other necessary actions
                return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            if (!$service){
                throw $this->createNotFoundException("No service found for {$id} id");
            }
            
            // Parse the JSON data from the request body
            $data = json_decode($request->getContent(), true);

            // Update the service entity with the new data
            $service->setNom($data['nom'] ?? $service->getNom());
            $service->setDescription($data['description'] ?? $service->getDescription());
            $service->setUpdatedAt(new DateTimeImmutable());

            // Persist the changes to the database
            $this->entityManager->flush();

            // Return a success response
            return new JsonResponse(['message' => 'Service updated successfully'], Response::HTTP_OK);
            } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error, display a custom error message, or perform any other necessary actions
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }


    #[Route('/services/delete/{id}',name: 'deleteService', methods: 'DELETE')]
    public function delete(int $id):Response
    {
        $service=$this->entityManager->getRepository(Service::class)->find($id);
        
        if (!$service){
            throw $this->createNotFoundException("No service found for {$id} id");
        }
        
        $this->entityManager->remove($service);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_admin',[
            'controller_name' => 'ServicesController',
            'service'=>$service // Passer la variables services qui contient tous les services
        ]);
    }

    
}
