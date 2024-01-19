<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Service;
Use App\Repository\ServiceRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use App\Entity\Zoo;
use App\Repository\ZooRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
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
}
