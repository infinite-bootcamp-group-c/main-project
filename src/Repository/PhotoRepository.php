<?php

namespace App\Repository;

use App\Entity\Photo;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use App\Lib\Repository\Pagination\HasRepositoryPaginator;
use Doctrine\Persistence\ManagerRegistry;

class PhotoRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

//    /**
//     * @return Photo[] Returns an array of Photo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Photo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
