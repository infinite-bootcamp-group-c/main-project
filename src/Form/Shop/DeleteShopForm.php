<?php

namespace App\Form\Shop;

use App\Lib\Form\ABaseForm;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteShopForm extends ABaseForm
{

    public function __construct(
        private readonly ShopRepository $shopRepository,
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
        $shopId = self::getParams($request)['route']['id'];
        try {
            $this->shopRepository->removeById($shopId);
        } catch (EntityNotFoundException) {
            throw new NotFoundHttpException("Shop {$shopId} not Found");
        }
    }
}