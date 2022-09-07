<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Repository\ShopRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(private readonly ShopRepository $shopRepository)
    {
    }

    public function load(ObjectManager $manager)
    {
        $configs = include('src/DataFixtures/FixtureConfig.php');
        $category_cnt = $configs['category_cnt'];
        $category_unique = $configs['category_unique'];
        // create 3 categories for each 3 shops
        for ($i = 1; $i <= $category_cnt; $i++) {
            $category = new Category();
            $shopId = ($i-1)%$category_unique + 1;

            $category->setShop($this->shopRepository->find($shopId));
            $category->setTitle('category'.$i);

            $manager->persist($category);
        }

        $manager->flush();
    }


    public static function getGroups(): array
    {
        return ['category'];
    }
}