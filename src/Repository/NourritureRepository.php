<?php

namespace App\Repository;

use App\Entity\Nourriture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Nourriture>
 *
 * @method Nourriture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nourriture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nourriture[]    findAll()
 * @method Nourriture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NourritureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nourriture::class);
    }

//    /**
//     * @return Nourriture[] Returns an array of Nourriture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Nourriture
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
