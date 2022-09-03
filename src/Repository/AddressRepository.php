<?php

namespace App\Repository;

use App\Entity\Address;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\HasPaginator;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ABaseRepository implements IBaseRepository
{
    use HasPaginator;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

//    /**
//     * @return Address[] Returns an array of Address objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Address
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
