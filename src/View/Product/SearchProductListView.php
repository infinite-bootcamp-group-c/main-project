<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\ABaseView;


class SearchProductListView extends ABaseView
{
    public function execute(array $products): array
    {
        return array_map(function (Product $product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
            ];
        }, $products);
    }
}