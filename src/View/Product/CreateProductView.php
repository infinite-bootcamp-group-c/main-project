<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;


class CreateProductView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

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