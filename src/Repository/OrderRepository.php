<?php

namespace App\Repository;

use App\Entity\Enums\OrderStatus;
use App\Entity\Order;
use App\Entity\Shop;
use App\Entity\User;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function createOrder(User $user, Shop $shop,): Order
    {
        $order = new Order();
        $order->setShop($shop);
        $order->setStatus(OrderStatus::OPEN);
        $order->setUser($user);
        return $order;
    }
}
