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
#[Route('/admin', name: 'app_admin_')]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        EntityManagerInterface $entityManager,
        MailerService $mailerService,
    ): Response
    {
    if (!$this->isGranted('ROLE_ADMIN')) {
        return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }
    try{
    $sentEmail = $request->request->get('email');
    $sentPassword = $request->request->get('plainPassword');

    $email = htmlspecialchars(trim($sentEmail));
    $password = htmlspecialchars(trim($sentPassword));
    $user = new User(
        $email,
        $password,
        [$request->request->get('Roles')],
        new \DateTimeImmutable(),
        null,
        1
    );
    $context = ['user'=>$user];
    $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
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