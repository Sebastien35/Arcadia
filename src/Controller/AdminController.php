<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Service;
Use App\Repository\ServiceRepository;

class AdminController extends AbstractController
{

    #[Route('/admin', name: 'app_admin')]
    public function index(ServiceRepository $servRepo): Response
    {
        $services = $servRepo->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'services'=>$services
        ]);
    }
}
