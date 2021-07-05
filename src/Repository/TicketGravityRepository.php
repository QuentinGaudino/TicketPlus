<?php

namespace App\Repository;

use App\Entity\TicketGravity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TicketGravity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketGravity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketGravity[]    findAll()
 * @method TicketGravity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketGravityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketGravity::class);
    }

    // /**
    //  * @return TicketGravity[] Returns an array of TicketGravity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TicketGravity
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
