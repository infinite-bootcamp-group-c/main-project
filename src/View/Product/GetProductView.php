<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\AListView;
use App\Repository\ProductRepository;


class GetProductView extends AListView implements IGetProductView
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function execute(array $params): array
    {
        $product = $this->getData($params);
        return $this->createResponse($product);
    }

    public function getData(array $form): Product
    {
        return $this->productRepository->find($form['route']['id']);
    }

    public function createResponse($product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
            'created_at' => $product->getCreatedAt(),
            'updated_at' => $product->getUpdatedAt(),
        ];
    }
}