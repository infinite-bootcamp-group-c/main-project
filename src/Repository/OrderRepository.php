<?php

namespace App\Repository;

use App\Entity\Enums\OrderStatus;
use App\Entity\Order;
use App\Entity\Shop;
use App\Entity\User;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use App\Lib\Repository\Pagination\HasRepositoryPaginator;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function createOrder(User $user, Shop $shop, ): Order
    {
        $order = new Order();
        $order->setShop($shop);
        $order->setStatus(OrderStatus::OPEN);
        $order->setUser($user);
        return $order;
    }

//    /**
//     * @return Order[] Returns an array of Order objects
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

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
