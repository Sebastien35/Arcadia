<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Sanitizer;


use DateTime;
use DateTimeImmutable;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Entity\Zoo;
use App\Repository\ZooRepository;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Form\AvisType;


#[Route('/avis', name: 'app_avis_')]
class AvisController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private AvisRepository $repository
        )
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $avisList = $this->entityManager->getRepository(Avis::class)->findAll();
        $avisForm = $this->createForm(AvisType::class);
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
            'avisList'=>$avisList,
            'avisForm'=>$avisForm->createView()
        ]);
    }
    
    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, Sanitizer $sanitizer): Response
    {
        $form = $this->createForm(AvisType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $avis = new Avis();
                $avis->setPseudo($sanitizer->sanitizeHtml($form->get('pseudo')->getData()));
                $avis->setAvisContent($sanitizer->sanitizeHtml($form->get('Avis_content')->getData()));
                $avis->setNote($form->get('note')->getData());
                $avis->setZoo($form->get('zoo')->getData());
                $avis->setCreatedAt(new DateTimeImmutable());
                $avis->setValidation(false);              
                $entityManager->persist($avis);
                $entityManager->flush();
                return $this->redirectToRoute('app_avis_index');
            } catch (\Exception $e) {
                return $this->redirectToRoute('app_avis_index', ['error' => $e->getMessage()]);
            }
        }
        return $this->redirectToRoute('app_avis_index');
    }
    


    #[Route('/show/{id}',name: 'show', methods: 'GET')]
    public function show(int $id):Response
    {
        $avis = $this->entityManager->getRepository(Avis::class)->find($id);
        if (!$avis){
            throw $this->createNotFoundException(
                'No avis found for id '.$id
            );
        }
        return $this->render('avis/show.html.twig', [
            'controller_name' => 'AvisController',
            'avis'=>$avis //
        ]);
    }
  

}
