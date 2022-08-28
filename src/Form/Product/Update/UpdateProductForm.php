<?php

namespace App\Form\Product\Update;

use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\View\Product\Update\IUpdateProductView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateProductForm extends ABaseForm implements IUpdateProductForm
{

    public function __construct(
        private readonly IUpdateProductView    $updateProductView,
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

    public function execute(Request $request): array
    {
        $form = self::getParams($request);

        $product = $this->productRepository->find($form['route']['id']);

        isset($form['body']["name"]) && $product->setName($form['body']['name']);
        isset($form['body']['price']) && $product->setPrice($form['body']['price']);
        isset($form['body']['category_id']) && $product->setCategory($this->categoryRepository->find($form['body']['category_id']));
        isset($form['body']['description']) && $product->setDescription($form['body']['description']);
        isset($form['body']['quantity']) && $product->setQuantity($form['body']['quantity']);

        $this->productRepository->flush();

        return $this->updateProductView->execute($product);
    }
}