<?php

namespace App\Repository;

use App\Entity\CreditInfo;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class CreditInfoRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditInfo::class);
    }

//    /**
//     * @return CreditInfo[] Returns an array of CreditInfo objects
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

//    public function findOneBySomeField($value): ?CreditInfo
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
