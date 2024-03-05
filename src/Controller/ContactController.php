<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DemandeContact;
use App\Form\DemandeContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


#[Route('/contact', name: 'app_contact_')]
class ContactController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        )
    {
        $this->entityManager=$entityManager;
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
            try {
                $demandeContact = $form->getData();
                $this->entityManager->persist($demandeContact);
                $this->entityManager->flush();
                
                $this->addFlash('success', 'Votre demande a bien été enregistrée');
                
                // Rediriger vers la page de contact
                return $this->redirectToRoute('app_contact_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue: '.$e->getMessage());
            }
        }
    }
    return $this->render('contact/index.html.twig', [
        'controller_name' => 'ContactController',
        'form' => $form->createView(),
    ]);
}
}
