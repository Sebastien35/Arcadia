<?php

namespace App\Repository;

use App\Entity\InfoAnimal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use function PHPUnit\Framework\isNull;

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

public function FilterByAnimalAndOrByDate($animal_id, $date) {
    $query = $this->createQueryBuilder('request');

    if (!empty($animal_id)) {
        $query->andWhere('request.animal = :animal_id')
              ->setParameter('animal_id', $animal_id);
    }

    if (!empty($date)) {
        $createdAt = new \DateTime($date);
        $formattedDate = $createdAt->format('Y-m-d');
        $query->andWhere('request.createdAt BETWEEN :startOfDay AND :endOfDay')
              ->setParameter('startOfDay', $formattedDate . ' 00:00:00')
              ->setParameter('endOfDay', $formattedDate . ' 23:59:59');
    }

    return $query->getQuery()->getResult();
}
}