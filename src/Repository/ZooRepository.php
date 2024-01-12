<?php

namespace App\Repository;

use App\Entity\Zoo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Zoo>
 *
 * @method Zoo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zoo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zoo[]    findAll()
 * @method Zoo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZooRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zoo::class);
    }

//    /**
//     * @return Zoo[] Returns an array of Zoo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('z')
//            ->andWhere('z.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('z.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Zoo
//    {
//        return $this->createQueryBuilder('z')
//            ->andWhere('z.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
