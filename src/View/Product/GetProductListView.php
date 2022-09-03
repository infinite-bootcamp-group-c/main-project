<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\ABaseView;


class GetProductListView extends ABaseView
{
    public function execute(array $products): array
    {
        return $this->renderPaginated($products, function (Product $product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'category' => $product->getCategory()->getTitle(),
                'shop' => $product->getCategory()->getShop()->getName(),
                'price' => $product->getPrice(),
                'createdAt' => $product->getCreatedAt(),
                'updatedAt' => $product->getUpdatedAt(),
            ];
        });
    }
}