<?php

namespace App\Repository;

use App\Entity\Horaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Horaire>
 *
 * @method Horaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Horaire[]    findAll()
 * @method Horaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Horaire::class);
    }

//    /**
//     * @return Horaire[] Returns an array of Horaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Horaire
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
