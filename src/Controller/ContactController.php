<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DemandeContact;
use App\Form\DemandeContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use DateTimeImmutable;
use App\Service\Sanitizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Zoo;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\EncryptionService;



#[Route('/contact', name: 'app_contact_')]
class ContactController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private sanitizer $sanitizer,
        private SerializerInterface $serializer,
        private UserPasswordHasherInterface $passwordHasher,
        private EncryptionService $encryptionService
        )
    {
        $this->entityManager=$entityManager;
        $this->sanitizer=$sanitizer;
        $this->serializer = $serializer;
        $this->passwordHasher = $passwordHasher;
        $this->encryptionService = $encryptionService;
    }

    
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
public function index(Request $request): Response
{
    $form = $this->createForm(DemandeContactType::class);
    //Gérer soumission  formulaire si requête POST
    if ($request->isMethod('POST')) {
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            
                // Enregistrer la demande de contact
                try{
                $demandeContact = new DemandeContact($this->encryptionService);
                $demandeContact -> setTitre(
                    $this->sanitizer->sanitizeHtml($form->get('titre')->getData()));
                $demandeContact -> setMessage(
                    $this->sanitizer->sanitizeHtml($form->get('message')->getData()));
                $PlainEmail = $form->get('mail')->getData();
                } catch(\Exception $e){
                    throw new \Exception($e->getMessage());
                }
                try{
                $CryptedEmail = $this->encryptionService->encyrpt($PlainEmail);
                $demandeContact->setMail($CryptedEmail);
                } catch (\Exception $e){
                    throw new \Exception($e->getMessage());
                }
                $demandeContact->setCreatedAt(new DateTimeImmutable());
                $demandeContact->setAnswered(false);
                $demandeContact->setZoo($form->get('zoo')->getData());

            
                $this->entityManager->persist($demandeContact);
                $this->entityManager->flush();
                
                $this->addFlash('success', 'Votre demande a bien été enregistrée.
                Nous vous répondrons dans les plus brefs délais. Merci!');
            
                // Rediriger vers la page de contact
                return $this->redirectToRoute('app_contact_index');
           
        }
    }
    return $this->render('contact/index.html.twig', [
        'controller_name' => 'ContactController',
        'form' => $form->createView(),
    ]);

}

    #[Route('/all',name: 'GetAllContacts', methods: 'GET')]
    public function getAllContacts():Response
    {
        if($this->getUser() == null){
            throw $this->createAccessDeniedException('You are not allowed to access this page');
        }
        try{
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $contacts = $this->entityManager->getRepository(DemandeContact::class)->findAll();
        foreach($contacts as $contact){
            $contact->setMail($this->encryptionService->decrypt($contact->getMail()));
        }
        $context = ['groups' => 'demande:read'];
        return JsonResponse::fromJsonString($this->serializer->serialize
        ($contacts, 'json', $context), 
        Response::HTTP_OK);
    }   catch(\Exception $e){
        throw new \Exception($e->getMessage());
    }
    }

}