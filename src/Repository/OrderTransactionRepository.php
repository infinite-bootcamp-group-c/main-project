<?php

namespace App\Repository;

use App\Entity\OrderTransaction;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use App\Lib\Repository\Pagination\HasRepositoryPaginator;
use Doctrine\Persistence\ManagerRegistry;

class OrderTransactionRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderTransaction::class);
    }

//    /**
//     * @return OrderTransaction[] Returns an array of OrderTransaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderTransaction
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
