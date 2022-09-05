<?php

namespace App\DataFixtures;

use App\Entity\Enums\OrderStatus;
use App\Entity\OrderTransaction;
use App\Repository\OrderRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Enums\OrderTransactionStatus;


class OrderTransactionFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private readonly OrderRepository $orderRepository,
    )
    {
    }

    public function load(ObjectManager $manager)
    {
        $configs = include('src/DataFixtures/FixtureConfig.php');
        $order_transaction_cnt = $configs['order_transaction_cnt'];
        $shop_cnt = $configs['address_cnt'];
        $user_cnt = $configs['user_cnt'];
        for ($i = 1; $i <= $order_transaction_cnt; $i++) {
            $order_transaction = new OrderTransaction();
            $order_transactionStatus = OrderTransactionStatus::from(mt_rand(0, 2));

            $order_transaction->setOrder($this->orderRepository->find($i));
            $order_transaction->setStatus($order_transactionStatus);
            $order_transaction->setAmount(mt_rand(1, 100) * 1000);

            $manager->persist($order_transaction);
        }

        $manager->flush();
    }


    public static function getGroups(): array
    {
        return ['order_transaction'];
    }
}