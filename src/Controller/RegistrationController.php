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
use App\Service\MailerService;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        UserAuthenticatorInterface $userAuthenticator, 
        AppCustomAuthAuthenticator $authenticator, 
        EntityManagerInterface $entityManager,
        UserRepository $userRepo,
        MailerService $mailerService,
    ): Response
    {
    if ($this->getUser() === null) {
        return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }
    try{
    
    $user = new User(
        $request->request->get('email'),
        $request->request->get('plainPassword'),
        [$request->request->get('Roles')],
        new \DateTimeImmutable(),
        null,
        1
    );
    $email = $request->request->get('email');
    $context = ['user'=>$user];
    $plainPassword = $request->request->get('plainPassword');
    $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
    $user->setPassword($hashedPassword);
    $entityManager->persist($user);
    $entityManager->flush();
    
    // Envoyer Email de confirmation
    
    $mailerService->sendWelcomeEmail($email, $context);
    return $this->redirectToRoute('app_admin_index');
    }catch(\Exception $e){
    return $this->json(['error' => $e->getMessage()], 500);
    }
}



}