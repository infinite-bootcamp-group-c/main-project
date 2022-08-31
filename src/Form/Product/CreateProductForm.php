<?php

namespace App\Form\Product;

use App\Entity\Product;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateProductForm extends ABaseForm
{

    public function __construct(
        private readonly ValidatorInterface    $validator,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly ProductRepository     $productRepository,
        private readonly CategoryRepository    $categoryRepository,
    )
    {
        parent::__construct($this->validator, $this->tokenStorage);
    }

    public function constraints(): array
    {
        return [
            'body' => [
                'category_id' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'shop_id' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'name' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'Product name must contain only letters, numbers and underscores'),
                ],
                'price' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Type('integer'),
                    new Assert\positive(),
                ],
                'quantity' => [
                    new Assert\NotBlank(),
                    new Assert\Type('integer'),
                    new Assert\Positive(),
                ],
                'description' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 150, max: 1000),
                    new Assert\Regex(pattern: '/^\w+/', message: 'Description must contain only letters, numbers and underscores'),
                ],
            ],
        ];
    }

    public function execute(Request $request): Product
    {
        $form = self::getParams($request);

        $product = (new Product())
            ->setName($form["body"]["name"])
            ->setPrice($form["body"]["price"])
            ->setCategory(
                $this->categoryRepository->find($form["body"]["category_id"])
            )
            ->setDescription($form["body"]["description"])
            ->setQuantity($form["body"]["quantity"]);

        $this->productRepository->add($product, flush: true);

        return $product;
    }
}