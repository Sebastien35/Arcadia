<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AvisRepository;

class AcceuilController extends AbstractController
{
    #[Route('/', name: 'app_acceuil')]
    public function index(AvisRepository $avisRepository): Response
    {
        $avis = $avisRepository->findAll();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AcceuilController',
            'avis' => $avis
        ]);
    }
}
