<?php

namespace App\Form\Product;

use App\Entity\Product;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductForm extends ABaseForm
{

    public function __construct(
        private readonly ProductRepository  $productRepository,
        private readonly CategoryRepository $categoryRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [
            'route' => [
                'id' => [
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                ],
            ],
            'body' => [
                'category_id' => [
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'shop_id' => [
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'name' => [
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'Product name must contain only letters, numbers and underscores'),
                ],
                'price' => [
                    new Assert\Type('integer'),
                    new Assert\positive(),
                ],
                'quantity' => [
                    new Assert\Type('integer'),
                    new Assert\Positive(),
                ],
                'description' => [
                    new Assert\Length(min: 150, max: 1000),
                    new Assert\Regex(pattern: '/^\w+/', message: 'Description must contain only letters, numbers and underscores'),
                ],
            ],
        ];
    }

    public function execute(Request $request): Product
    {
        $form = self::getParams($request);

        $productId = $form['route']['id'];
        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new BadRequestException("Product ${productId} not found");
        }

        $categoryId = $form['body']['category_id'];
        $category = $this->categoryRepository->find($categoryId);

        if (!$category) {
            throw new BadRequestException("Category ${categoryId} not found");
        }

        isset($form['body']["name"]) && $product->setName($form['body']['name']);
        isset($form['body']['price']) && $product->setPrice($form['body']['price']);
        isset($form['body']['category_id']) && $product->setCategory($category);
        isset($form['body']['description']) && $product->setDescription($form['body']['description']);
        isset($form['body']['quantity']) && $product->setQuantity($form['body']['quantity']);

        $this->productRepository->flush();

        return $product;
    }
}