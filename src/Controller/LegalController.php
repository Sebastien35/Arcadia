<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/legal', name: 'app_legal_')]
class LegalController extends AbstractController
{
    
    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('legal/ml.html.twig');
    }

    #[Route('/politique-de-confidentialite', name: 'pdd')]
    public function pdd(): Response
    {
        return $this->render('legal/pdd.html.twig');
    }

}