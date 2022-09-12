<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;


class ProductFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public static function getGroups(): array
    {
        return ['product'];
    }

    public function load(ObjectManager $manager)
    {
        $configs = include('src/DataFixtures/FixtureConfig.php');
        $product_cnt = $configs['product_cnt'];
        $product_unique = $configs['product_unique'];
        for ($i = 1; $i <= $product_cnt; $i++) {
            $product = new Product();
            $categoryId = ($i - 1) % $product_unique + 1;

            $product->setName('Product ' . $i);
            $product->setCategory($this->categoryRepository->find($categoryId));
            $product->setDescription('description' . $i);
            $product->setQuantity($i % 3);
            $product->setPrice(($i % 4 + 1) * 10000);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
