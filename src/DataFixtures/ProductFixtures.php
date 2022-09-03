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

    public function load(ObjectManager $manager)
    {
        // create 3 products for each 9 categories
        for ($i = 1; $i < 28; $i++) {
            $product = new Product();
            $categoryId = ($i-1)/3 + 1;
            $product->setName('Product ' . $i);
            $product->setCategory($this->categoryRepository->find($categoryId));
            $product->setDescription('description'.$i);
            $product->setQuantity($i%3);
            $product->setPrice(($i%4+1)*10000);

            $manager->persist($product);
        }

        $manager->flush();
    }


    public static function getGroups(): array
    {
        return ['product'];
    }
}