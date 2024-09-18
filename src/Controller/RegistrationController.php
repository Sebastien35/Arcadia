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
        EntityManagerInterface $entityManager,
        MailerService $mailerService,
    ): Response
    {
    if ($this->getUser() === null) {
        return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }
    
    $csrfToken = $request->request->get('_csrf_token');
    if (!$this->isCsrfTokenValid('register', $csrfToken)) {
        throw new \Exception('Invalid CSRF token.');
    }
    
    $plainPassword = $request->request->get('plainPassword');
    if (empty($plainPassword ||
        strlen($plainPassword) < 8 ||
        strlen($plainPassword) > 20 ||
        !preg_match('/\d/', $plainPassword) || 
        !preg_match('/[^a-zA-Z0-9]/', $plainPassword) ||
        !preg_match('/([^a-zA-Z0-9].*[^a-zA-Z0-9])|([^a-zA-Z0-9]{2,})/', $plainPassword))) {
        throw new \Exception('Le mot de passe doit contenir entre 8 et 20 caractères, au moins un chiffre, une lettre et un caractère spécial.');
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