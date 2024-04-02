<?php

namespace App\Repository;

use App\Entity\AdditionalImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdditionalImages>
 *
 * @method AdditionalImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdditionalImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdditionalImages[]    findAll()
 * @method AdditionalImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdditionalImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdditionalImages::class);
    }

//    /**
//     * @return AdditionalImages[] Returns an array of AdditionalImages objects
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

//    public function findOneBySomeField($value): ?AdditionalImages
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    
}
