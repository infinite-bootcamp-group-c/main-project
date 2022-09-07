<?php

namespace App\Form\Product;

use App\Entity\Product;
use App\Lib\Form\ABaseForm;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class GetProductForm extends ABaseForm
{

    public function __construct(
        private readonly ProductRepository $productRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [
            'route' => [
                'id' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ],
            ],
        ];
    }

    public function execute(Request $request): Product
    {
        $form = self::getParams($request);

        $productId = $form['route']['id'];
        $product = $this->productRepository->find($productId);

        if (!$product)
            throw new NotFoundHttpException("Product ${productId} not found");

        return $product;
    }
}