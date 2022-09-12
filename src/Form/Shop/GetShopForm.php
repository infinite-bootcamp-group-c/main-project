<?php

namespace App\Form\Shop;

use App\Entity\Shop;
use App\Lib\Form\ABaseForm;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;


class GetShopForm extends ABaseForm
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

    public function execute(array $form): Shop
    {
        $shopId = $form['route']['id'];
        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new NotFoundHttpException("Shop ${shopId} not found");
        }

        return $shop;
    }
}
