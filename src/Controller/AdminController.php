<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Service;
Use App\Repository\ServiceRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Zoo;
use App\Repository\ZooRepository;
use App\Entity\Horaire;
use App\Repository\HoraireRepository;

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

    #[Route('/horaires', name: 'horairesAdmin', methods: ['GET'])]
    public function indexHoraires(HoraireRepository $horaireRepo): Response
    {
        $horaires = $horaireRepo->findAll();
        return $this->render('admin/horaires.html.twig', [
            'controller_name' => 'AdminController',
            'horaires'=>$horaires
        ]);
    }

    #[Route('/horaires/edit/{id}', name: 'editHoraire', methods: ['PUT'])]
    public function editHoraire(int $id_jour, Request $request): Response
    {
        $horaire=$this->entityManager->getRepository(Horaire::class)->find($id_jour);
        if(!$horaire){
            throw $this->createNotFoundException('No horaire found for  '.$id_jour);
        }
        $horaire->setHOuverture($request->request->get('h_ouverture'));
        $horaire->setHFermeture($request->request->get('h_fermeture'));
        return $this->redirectToRoute('app_admin_horairesAdmin');
    }

    #[Route('/horaires/show/{id}',name: 'showHoraire', methods: ['GET'])]
    public function showHoraire(int $id):Response
    {   
        
        $horaire = $this->entityManager->getRepository(Horaire::class)->find($id);
        dd($id, $horaire);
        if (!$horaire){
            throw $this->createNotFoundException(
                'No horaire found for id '.$id
            );
        }
        return $this->render('admin/showHoraire.html.twig', [
            'controller_name' => 'AdminController',
            'horaire'=>$horaire // 
        ]);
    }
}
