<?php

namespace App\Tests\Repository;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;

class ProductRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;


    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->productRepository = $this->entityManager->getRepository(Product::class);
        $this->categoryRepository = $this->entityManager->getRepository(Category::class);
    }

    public function testFindAll(): void
    {
        $products = $this->productRepository->findAll();
        $this->assertNotEmpty($products);
    }

    public function testFind(): void
    {
        $product = $this->productRepository->find(1);
        $this->assertEquals('Product 1', $product->getName());
    }

    public function testAdd(): void
    {
        $product = new Product();

        $products = $this->productRepository->findAll();
        $count = count($products) + 1;

        $product->setName('Product '.$count);
        $product->setCategory($this->categoryRepository->find(1));
        $product->setDescription('description'.$count);
        $product->setQuantity(1);
        $product->setPrice(10000);

        $this->productRepository->add($product, true);

        $product = $this->productRepository->find($count);
        $this->assertEquals('Product '.$count, $product->getName());
    }
}