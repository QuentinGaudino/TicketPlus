<?php

namespace App\Repository;

use App\Entity\DemandCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandCategory[]    findAll()
 * @method DemandCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandCategory::class);
    }

    // /**
    //  * @return DemandCategory[] Returns an array of DemandCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemandCategory
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
