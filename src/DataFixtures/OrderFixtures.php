<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Repository\UserRepository;
use App\Repository\ShopRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Enums\OrderStatus;

class OrderFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ShopRepository $shopRepository,
    )
    {
    }

    public function load(ObjectManager $manager)
    {
        $configs = include('src/DataFixtures/fixtureConfig.php');
        $order_cnt = $configs['order_cnt'];
        $shop_cnt = $configs['address_cnt'];
        $user_cnt = $configs['user_cnt'];
        // create 10 orders! Bam!
        for ($i = 1; $i <= $order_cnt; $i++) {
            $order = new Order();

            $shopId = ($i-1)%$shop_cnt+1;
            $user_id = ($i-1)%$user_cnt+1;
            $orderStatus = OrderStatus::from(mt_rand(0, 4));


            //mt_rand(1, $shop_unique)
            $order->setShop($this->shopRepository->find($shopId));
            $order->setUser($this->userRepository->find($user_id));
            $order->setStatus($orderStatus);
            $order->setTotalPrice(mt_rand(1, 100) * 1000);

            $manager->persist($order);
        }

        $manager->flush();
    }


    public static function getGroups(): array
    {
        return ['order'];
    }
}