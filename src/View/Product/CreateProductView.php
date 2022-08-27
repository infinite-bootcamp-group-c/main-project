<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\AListView;


class CreateProductView extends AListView implements ICreateProductView
{
    public function __construct()
    {
    }

    public function getData(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
        ];
    }

    public function execute(Product $product): array
    {
        return $this->getData($product);
    }
}