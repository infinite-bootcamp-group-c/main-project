<?php

namespace App\Form\Product;

use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteProductForm extends ABaseForm
{

    use HasValidateOwnership;

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

    public function execute(Request $request): void
    {
        $productId = self::getParams($request)['route']['id'];
        $product = $this->productRepository->find($productId);

        if(!$product) {
            throw new BadRequestHttpException("Product {$productId} Not Found");
        }

        $shop = $product->getCategory()->getShop();
        $this->validateOwnership($shop, $this->getUser()->getId());

        $this->productRepository->remove($product, true);
    }
}