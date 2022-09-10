<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderItemRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }

    public function createOrderItem(Product $product, int $quantity, Order $order): OrderItem
    {
        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setQuantity($quantity);
        $orderItem->setUnitPrice($product->getPrice());
        $orderItem->setOrder($order);

        return $orderItem;
    }

//    /**
//     * @return OrderItem[] Returns an array of OrderItem objects
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

//    public function findOneBySomeField($value): ?OrderItem
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
