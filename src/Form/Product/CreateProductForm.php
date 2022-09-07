<?php

namespace App\Form\Product;

use App\Entity\Product;
use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProductForm extends ABaseForm
{

    use HasValidateOwnership;

    public function __construct(
        private readonly ProductRepository  $productRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly ShopRepository $shopRepository,
    )
    {
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
                'name' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'The product name {{ value }} is not valid.'),
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
                    new Assert\Length(max: 1000),
                    new Assert\Regex(pattern: '/^\w+/',
                        message: 'The description {{ value }} is not valid.'),
                ],
            ],
        ];
    }

    public function execute(Request $request): Product
    {
        $form = self::getParams($request);

        $categoryId = $form['body']['category_id'];
        $category = $this->categoryRepository->find($categoryId);

        if(!$category)
            throw new BadRequestHttpException("Category {$categoryId} not found");

        $this->validateOwnership($category->getShop(), $this->getUser()->getId());

        $product = (new Product())
            ->setName($form["body"]["name"])
            ->setPrice($form["body"]["price"])
            ->setCategory($category)
            ->setDescription($form["body"]["description"])
            ->setQuantity($form["body"]["quantity"]);

        $this->productRepository->add($product, flush: true);

        return $product;
    }
}