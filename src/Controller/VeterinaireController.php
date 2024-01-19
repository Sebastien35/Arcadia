<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VeterinaireController extends AbstractController
{
    #[Route('/veterinaire', name: 'app_veterinaire')]
    public function index(): Response
    {
        return $this->render('veterinaire/index.html.twig', [
            'controller_name' => 'VeterinaireController',
        ]);
    }
}
