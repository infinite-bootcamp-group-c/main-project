<?php

namespace App\Repository;

use App\Entity\Product;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public static function checkQuantity(Product $product, int $count)
    {
        if ($product->getQuantity() < $count){
            throw new BadRequestHttpException("Product stock is not enough for this quantity");
        }
    }
}
