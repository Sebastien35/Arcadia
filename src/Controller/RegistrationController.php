<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\AppCustomAuthAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Zoo;
use App\Repository\ZooRepository;
use App\Repository\UserRepository;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthAuthenticator $authenticator, EntityManagerInterface $entityManager,UserRepository $userRepo, ZooRepository $ZooRepo): Response
    {   
        $users=$userRepo->findAll();
        $zoos=$ZooRepo->findAll();

        $worksAtId = $request->request->get('worksAt');
        $worksAt = $entityManager->getRepository(Zoo::class)->find($worksAtId);
        $user = new User(
            $request->request->get('email'),
            $request->request->get('plainPassword'),
            [$request->request->get('Roles')],
            new \DateTimeImmutable(),
            null,
           $worksAt,
        ); 
    
    $plainPassword = $request->request->get('plainPassword');
    $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
    $user->setPassword($hashedPassword);
    $entityManager->persist($user);
    $entityManager->flush();
    
    // Envoyer Email de confirmation
    
    // return $userAuthenticator->authenticateUser(
    //            $user,
    //            $authenticator,
    //            $request
    //        );
    //    }
    return $this->render('admin/users.html.twig', [
        'controller_name' => 'RegistrationController',
        'zoos'=>$zoos,
        'users'=>$users
    ]);
    }
        
    


}

