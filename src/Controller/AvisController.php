<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use DateTime;
use DateTimeImmutable;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Entity\Zoo;
use App\Repository\ZooRepository;

#[Route('/avis', name: 'app_avis_')]
class AvisController extends AbstractController
{   
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
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
    public function create(Request $request): Response
    {   

        $arcadiaZoo = $this->entityManager->getRepository(Zoo::class)->find(1);

        $avis = new Avis(
            $request->request->get('pseudo'),
            $request->request->get('Avis_content'),
            (int) $request->request->get('note'), // Cast to int assuming note is an integer
            false,
            $arcadiaZoo,
            new \DateTimeImmutable(),
            
        );

        $this->entityManager->persist($avis);
        $this->entityManager->flush();
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

    #[Route('/update/{id}',name: 'update', methods: 'PUT')]
    public function update(int $id):Response
    {
        $avis = $this->entityManager->getRepository(Avis::class)->find($id);
        if (!$avis){
            throw $this->createNotFoundException(
                'No avis found for id '.$id
            );
        }
        $avis->setValidation(true);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_avis_index');
    }



    #[Route('/delete/{id}',name: 'delete', methods: 'DELETE')]
    public function delete(int $id):Response
    {
        $avis = $this->entityManager->getRepository(Avis::class)->find($id);
        if (!$avis){
            throw $this->createNotFoundException(
                'No avis found for id '.$id
            );
        }
        $this->entityManager->remove($avis);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_avis_index');
    }

    

}
