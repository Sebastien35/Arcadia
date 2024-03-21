<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



use DateTime;
use DateTimeImmutable;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Entity\Zoo;
use App\Repository\ZooRepository;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

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
    public function index(): Response
    {
        $avisList = $this->entityManager->getRepository(Avis::class)->findAll();
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
            'avisList'=>$avisList // Passer la variables avisList qui contient tous les avisList
        ]);
    }

    #[Route('/create', name: 'create', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        try{
        $avis = $this->serializer->deserialize($request->getContent(), Avis::class, 'json');
        $avis->setCreatedAt(new DateTimeImmutable());
        $avis->setValidation(false);
        $avis->setZoo($this->entityManager->getRepository(Zoo::class)->find(1));   

        $this->entityManager->persist($avis);
        $this->entityManager->flush();
        return new JsonResponse($this->serializer->serialize($avis, 'json'), JsonResponse::HTTP_CREATED, [], true);
        }
        catch(\Exception $e){
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
