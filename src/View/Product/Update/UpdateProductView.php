<?php

namespace App\View\Product\Update;

use App\Entity\Product;
use App\Lib\View\ABaseView;


class UpdateProductView extends ABaseView
{
    public function __construct()
    {
    }

    public function execute(Product $product): array
    {
        return $this->getData($product);
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
}