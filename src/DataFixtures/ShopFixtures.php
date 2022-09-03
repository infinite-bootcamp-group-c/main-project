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

    public function load(ObjectManager $manager)
    {
        // create 3 shops! Bam!
        for ($i = 1; $i < 4; $i++) {
            $shop = new Shop();
            $shop->setName('user'.$i);
            $shop->setUser($this->userRepository->find(mt_rand(1, 3)));
            $shop->setDescription('Test description for shop'.$i);
            $shop->setIgUsername('ig'.$i);

            $manager->persist($shop);
        }

        $manager->flush();
    }


    public static function getGroups(): array
    {
        return ['shop'];
    }
}