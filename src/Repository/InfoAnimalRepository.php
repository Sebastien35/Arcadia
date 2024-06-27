<?php

namespace App\Repository;

use App\Entity\InfoAnimal;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTimeInterface;

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

    public function filtrerParAnimalEtOuParJour(int $animalId = null, DateTimeImmutable $createdAt = null): iterable {
        $queryBuilder = $this->createQueryBuilder('request  ');
        if (!empty($animalId)) {
            $queryBuilder->andWhere('request.animal = :animalId')
               ->setParameter('animalId', $animalId);
        }
        if (!empty($createdAt)) {
            $formattedDate = $createdAt->format('Y-m-d');
            $queryBuilder->andWhere('request.createdAt BETWEEN :startOfDay AND :endOfDay')
               ->setParameter('startOfDay', $formattedDate . ' 00:00:00')
               ->setParameter('endOfDay', $formattedDate . ' 23:59:59');
        }
    
        $query = $queryBuilder->getQuery();
        
    
        return $query->getResult();

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
