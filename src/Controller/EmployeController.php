<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Avis;
use App\Repository\AvisRepository;




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
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
            'avisList'=>$avisList // Passer la variables avisList qui contient tous les avis
        ]);
    }

    
}
