<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;


class ShopFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public static function getGroups(): array
    {
        return ['shop'];
    }

    public function load(ObjectManager $manager)
    {
        $configs = include('src/DataFixtures/FixtureConfig.php');
        $shop_cnt = $configs['address_cnt'];
        $shop_unique = $configs['shop_unique'];
        for ($i = 1; $i <= $shop_cnt; $i++) {
            $shop = new Shop();

            $shop->setName('user' . $i);
            $shop->setUser($this->userRepository->find(mt_rand(1, $shop_unique)));
            $shop->setDescription('Test description for shop' . $i);
            $shop->setIgUsername('ig' . $i);

            $manager->persist($shop);
        }

        $manager->flush();
    }
}
