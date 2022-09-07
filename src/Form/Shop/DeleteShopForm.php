<?php

namespace App\Form\Shop;

use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteShopForm extends ABaseForm
{
    use HasValidateOwnership;

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
        $shop = $this->shopRepository->find($shopId);

        if(!$shop) {
            throw new BadRequestHttpException("Shop {$shopId} Not Found");
        }

        $this->validateOwnership($shop, $this->getUser()->getId());

        $this->shopRepository->remove($shop, true);
    }
}