<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/services', name: 'app_services_')]
class ServicesController extends AbstractController
{   
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/', name: 'index_')]
    public function index(ServiceRepository $servRepo): Response
    {   
        $services = $servRepo->findAll();
        return $this->render('services/index.html.twig', [
            'controller_name' => 'ServicesController',
            'services'=>$services // Passer la variables services qui contient tous les services
        ]);
    
    }



    #[Route('/create', name: 'create', methods: 'POST')]
    public function new(Request $request): Response
    {
        $service = new Service(
            $request->request->get('nom'),
            $request->request->get('description'),
            (int) $request->request->get('prix'), // Cast to int assuming prix is an integer
            new \DateTimeImmutable(),
            null // Assuming updatedAt can be null initially, adjust if needed
        );

        $this->entityManager->persist($service);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_services_index_');
    }

    
    #[Route('/show/{id}',name: 'show', methods: 'GET')]
    public function show(int $id):Response
    {
        $service = $this->entityManager->getRepository(Service::class)->find($id);
        if (!$service){
            throw $this->createNotFoundException("No service found for {$id} id");
        }
        return $this->render('services/show.html.twig', [
            'controller_name' => 'ServicesController',
            'service'=>$service // Passer la variable qui contient le service correspondant à l'ID recherché
        ]);
    }
    
    
    
    #[Route('/update/{id}',name: 'update', methods: 'PUT')]
    public function edit(int $id, Request $request):Response
    {   
        
        $service = $this->entityManager->getRepository(Service::class)->find($id);
        if (!$service){
            throw $this->createNotFoundException("No service found for {$id} id");
        }
        
        $service->setNom($request->request->get('nom'));
        $service->setDescription($request->request->get('description'));
        $service->setPrix($request->request->get('prix'));
        $service->setUpdatedAt(new DateTimeImmutable());

        $this->entityManager->persist($service);
        $this->entityManager->flush();
        var_dump($service);
        return $this->redirectToRoute('app_admin');
        

    }


    #[Route('/delete/{id}',name: 'delete', methods: 'DELETE')]
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

