<?php

namespace App\Form\Product;

use App\Lib\Form\ABaseForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteProductForm extends ABaseForm
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

    public function execute(Request $request): void
    {
        $productId = self::getParams($request)['route']['id'];

        if($this->productRepository->find($productId)
                ->getCategory()
                ->getShop()
                ->getUser()
                ->getId() !== $this->getUser()->getId()
        ){
            throw new BadRequestException('You are not allowed to delete this product');
        }

        try {
            $this->productRepository->removeById($productId);
        } catch (EntityNotFoundException) {
            throw new NotFoundHttpException("Product {$productId} Not Found");
        }
    }
}