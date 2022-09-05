<?php

namespace App\Repository;

use App\Entity\Shop;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use App\Lib\Repository\Pagination\HasRepositoryPaginator;
use Doctrine\Persistence\ManagerRegistry;

class ShopRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }

//    /**
//     * @return Shop[] Returns an array of Shop objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Shop
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
