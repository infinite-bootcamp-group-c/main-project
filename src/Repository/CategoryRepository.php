<?php

namespace App\Repository;

use App\Entity\Category;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\HasPaginator;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ABaseRepository implements IBaseRepository
{
    use HasPaginator;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

//    /**
//     * @return Category[] Returns an array of Category objects
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

//    public function findOneBySomeField($value): ?Category
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
