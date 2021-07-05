<?php

namespace App\Repository;

use App\Entity\IncidentCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IncidentCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncidentCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncidentCategory[]    findAll()
 * @method IncidentCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidentCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IncidentCategory::class);
    }

    // /**
    //  * @return IncidentCategory[] Returns an array of IncidentCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IncidentCategory
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
