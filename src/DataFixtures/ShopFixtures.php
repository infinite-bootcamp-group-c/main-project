<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public static function getGroups(): array
    {
        return ['shop', 'order', 'category', 'product'];
    }

    public function load(ObjectManager $manager)
    {
        $configs = include('src/DataFixtures/FixtureConfig.php');
        $shop_cnt = $configs['shop_cnt'];
        $user_cnt = $configs['user_cnt'];
        for ($i = 1; $i <= $shop_cnt; $i++) {
            $shop = new Shop();

            $shop->setName('user' . $i);
            $shop->setUser($this->userRepository->find(mt_rand(1, $user_cnt)));
            $shop->setDescription('Test description for shop' . $i);
            $shop->setIgUsername('ig' . $i);

            $manager->persist($shop);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

}
