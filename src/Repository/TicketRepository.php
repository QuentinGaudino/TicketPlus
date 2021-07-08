<?php

namespace App\Repository;

use App\Entity\Ticket;
use App\Entity\TicketStatus;
use App\Entity\TicketType;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, TicketStatusRepository $ticketStatusRepository, TicketTypeRepository $ticketTypeRepository)
    {
        parent::__construct($registry, Ticket::class);
        $this->statusRepo = $ticketStatusRepository;
        $this->typeRepo = $ticketTypeRepository;

    }

    /**
    * @return Ticket[] Returns an array of Ticket objects
    */
    public function filteredTickets(?array $get, ?User $user) : array
    {
        $qb = $this->createQueryBuilder('t');

        //Vérification de l'existance ou non de clées dans le tableau $get
        if (array_key_exists('status', $get)) {
            $status = $this->statusRepo->findOneBy(['name' => $get['status']]);
        }else{
            $status = null;
        }

        if (array_key_exists('type', $get)) {
            $type = $this->typeRepo->findOneBy(['name' => $get['type']]);
        }else{
            $type = null;
        }

        if (array_key_exists('beginDate', $get)) {
            $beginDate = $get['beginDate'];
        }else{
            $beginDate = null;
        }

        if (array_key_exists('endDate', $get)) {
            $endDate = $get['endDate'];
        }else{
            $endDate = null;
        }

        if (array_key_exists('search', $get)) {
            $search = $get['search'];
        }else{
            $search = null;
        }

        if ($status && $status != 'allStatus') {
            $qb->andWhere('t.status = :status')
            ->setParameter('status', $status);
        }

        if ($type && $type != 'allType') {
            $qb->andWhere('t.type = :type')
            ->setParameter('type', $type);
        }

        if ($beginDate) {
            $qb->andWhere('t.Creation_date >= :beginDate')
            ->setParameter('beginDate', $beginDate);
        }

        if ($endDate) {
            $qb->andWhere('t.Creation_date <= :endDate')
            ->setParameter('endDate', $endDate);
        }

        if ($user) {
            $qb->andWhere('t.author = :author')
            ->setParameter('author', $user);
        }

        if ($search) {
            $preResults = $qb->getQuery()->getResult();
            $results = [];
            foreach ($preResults as $ticket) {
                if (stristr($ticket->getName(), $search) || stristr($ticket->getDescription(), $search)) {
                    $results[] = $ticket;
                }
            }
            return $results;
        }
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Ticket
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
