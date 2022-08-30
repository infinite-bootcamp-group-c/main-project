<?php

namespace App\View\Product\GetList;

use App\Entity\Product;
use App\Lib\View\ABaseView;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class GetProductListView extends ABaseView
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function execute(array $params): array
    {
        $products = $this->getData($params);
        return $this->createResponse($products);
    }

    public function getData(array $form): array
    {
        return $this->productRepository->findAll();
    }

    public function createResponse($products): array
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