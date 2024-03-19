<?php

namespace App\Repository;

use App\Entity\InfoAnimal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InfoAnimal>
 *
 * @method InfoAnimal|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoAnimal|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoAnimal[]    findAll()
 * @method InfoAnimal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoAnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoAnimal::class);
    }

//    /**
//     * @return InfoAnimal[] Returns an array of InfoAnimal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InfoAnimal
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
