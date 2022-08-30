<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\ABaseView;


class CreateProductView extends ABaseView
{

    public function execute(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
        ];
    }
}