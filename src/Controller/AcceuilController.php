<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Avis;
use App\Repository\AvisRepository;




class AcceuilController extends AbstractController
{
    public function __construct(AvisRepository $avisRepository)
    {
        $this->AvisRepository = $avisRepository;
    }


    #[Route('/', name: 'app_acceuil')]
    public function index(AvisRepository $avisRepository): Response
    {

        $avis = $this->AvisRepository->findAll();
        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}
