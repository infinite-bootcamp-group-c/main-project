<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\ACreateView;
use App\Repository\ProductRepository;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;


class CreateProductView extends ACreateView
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    protected function createObject(array $form): Product
    {
        /**
         * creates a Product entity
         */

        $product = new Product();
        static::setProductProperties($product, $form);
        $this->productRepository->add($product, true);
        return $product;
    }

    private function setProductProperties(Product $product, array $form): void
    {
        /**
         * Sets all properties of a product to the entity with their setter methods
         * TODO: add product photos
         */

        $product->setName($form["body"]["name"]);
        $product->setPrice($form["body"]["price"]);
        $product->setCategory($form["body"]["category"]);
        $product->setDescription($form["body"]["description"]);
        $product->setQuantity($form["body"]["quantity"]);
        $product->setCreatedAt(new DateTime());
        $product->setUpdatedAt(new DateTime());
    }

    public function createResponse(array $responseArray): JsonResponse
    {
        /**
         * creates Final response with given data and status
         */

        $response = new JsonResponse($responseArray);
        $response->setStatusCode(201, "new product created");
        return $response;
    }


    public static function execute(array $params): void
    {
        /**
         * it is called by a form object
         */
        $instance = new static();
        $product = $instance->createObject($params);
        $productArray = $instance->toArray($product);
        $response = $instance->createResponse($productArray);
        $response->send();
    }
}