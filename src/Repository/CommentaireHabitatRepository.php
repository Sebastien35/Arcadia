<?php

namespace App\Repository;

use App\Entity\CommentaireHabitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentaireHabitat>
 *
 * @method CommentaireHabitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireHabitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireHabitat[]    findAll()
 * @method CommentaireHabitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireHabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireHabitat::class);
    }

//    /**
//     * @return CommentaireHabitat[] Returns an array of CommentaireHabitat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CommentaireHabitat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
