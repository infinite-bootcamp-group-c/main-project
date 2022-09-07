<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\ABaseView;


class GetProductView extends ABaseView
{

    public function execute(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'category' => $product->getCategory()->getTitle(),
            'shop' => $product->getCategory()->getShop()->getName(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
            'created_at' => $product->getCreatedAt(),
            'updated_at' => $product->getUpdatedAt(),
        ];
    }

}