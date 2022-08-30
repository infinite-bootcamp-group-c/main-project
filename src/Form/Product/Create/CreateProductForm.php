<?php

namespace App\Form\Product\Create;

use App\Entity\Product;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\View\Product\Create\ICreateProductView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateProductForm extends ABaseForm implements ICreateProductForm
{

    public function __construct(
        private readonly ValidatorInterface    $validator,
        private readonly ProductRepository     $productRepository,
        private readonly CategoryRepository    $categoryRepository,
        private readonly TokenStorageInterface $tokenStorage,
    )
    {
        parent::__construct($this->validator, $this->tokenStorage);
    }

    public function constraints(): array
    {
        return [
            'query' => [
                'page' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ],
            ],
            'route' => [
                'id' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ],
            ],
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

    public function execute(Request $request)
    {
        $form = self::getParams($request);
        $product = new Product();
        $product->setName($form["body"]["name"]);
        $product->setPrice($form["body"]["price"]);
        $product->setCategory($this->categoryRepository->find($form["body"]["category_id"]));
        $product->setDescription($form["body"]["description"]);
        $product->setQuantity($form["body"]["quantity"]);
        $this->productRepository->add($product, flush: true);

        return $product;
    }
}