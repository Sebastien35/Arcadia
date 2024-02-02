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

    #[Route('/show/{id}',name: 'showService', methods: 'GET')]
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



   
    
    



}   

