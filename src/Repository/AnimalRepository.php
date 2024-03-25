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
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, Animal::class);
        
    }
    
    public function get4Animals(
        EntityManagerInterface $entityManager,
        AnimalRepository $animalRepository)
        {
            $rsm = new ResultSetMapping();
            $rsm->addEntityResult(Animal::class, 'a');
            $rsm->addFieldResult('a', 'id', 'id');
            $rsm->addFieldResult('a', 'prenom', 'prenom');
            $rsm->addFieldResult('a', 'imageName', 'imageName');

            $query = $entityManager->createNativeQuery(
                'SELECT * FROM animal ORDER BY RAND() LIMIT 4',
                $rsm
                
            );
            return $query->getResult();

        }
    




}
