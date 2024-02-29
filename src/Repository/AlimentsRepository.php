<?php

namespace App\Repository;

use App\Entity\Aliments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Aliments>
 *
 * @method Aliments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aliments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aliments[]    findAll()
 * @method Aliments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aliments::class);
    }

//    /**
//     * @return Aliments[] Returns an array of Aliments objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Aliments
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
