<?php

namespace App\Form\ShopAddress;

use App\Lib\Form\ABaseForm;
use App\Repository\ShopRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class GetShopAddressesForm extends ABaseForm
{
    public function __construct(
        private readonly ShopRepository $shopRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "shop_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ]
            ]
        ];
    }

    public function execute(Request $request): array
    {
        $route = self::getRouteParams($request);
        $shop_id = $route["shop_id"];
        $shop = $this->shopRepository
            ->find($shop_id);

        if (!$shop) {
            throw new BadRequestHttpException("Shop {$shop_id} Not Found");
        }

        return $shop->getAddresses()->getValues();
    }
}