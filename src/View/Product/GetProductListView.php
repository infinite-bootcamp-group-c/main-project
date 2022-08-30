<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\ABaseView;


class GetProductListView extends ABaseView
{

    public function execute(array $products): array
    {
        return array_map(function (Product $product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
                'created_at' => $product->getCreatedAt(),
                'updated_at' => $product->getUpdatedAt(),
            ];
        }, $products);
    }
}