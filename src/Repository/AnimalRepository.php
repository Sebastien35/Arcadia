<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @extends ServiceEntityRepository<Animal>
 *
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    )
    {
        parent::__construct($registry, Animal::class); 
    }
    

    public function findfirstfourIDs(): array
    {
        return $this->createQueryBuilder("a")
        ->select("a.id")
        ->orderBy('a.id', 'ASC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();
    }
    public function findTopAnimalsByName($limit): array
    {
        return $this->createQueryBuilder("a")
        ->select("a.id")
        ->orderBy('a.prenom', 'ASC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
    }

    public function findIDs($ids):array
    {   
       
       $result= $this->createQueryBuilder('a')
        ->select('a')
        ->where('a.id IN (:ids)')
        ->setParameter('ids', $ids)
        ->orderBy('a.id', 'ASC')
        ->getQuery()
        ->getResult();
        return $result;
    }

   

    public function getDifferentIds($ids):array
    {   
        // Retourne assez d'identifiants d'animaux pour atteindre un total de 4 
        // EN COMTANT CEUX DEJA DANS LA LISTE
        $additionalAnimalIds = $this->createQueryBuilder('a')
        ->select('a.id')
        ->where('a.id NOT IN (:ids)')
        ->setParameter('ids', $ids)
        ->orderBy('a.id', 'ASC')
        ->setMaxResults(4-count($ids))
        ->getQuery()
        ->getResult();
       
        
        return $additionalAnimalIds;
    }

    




}
