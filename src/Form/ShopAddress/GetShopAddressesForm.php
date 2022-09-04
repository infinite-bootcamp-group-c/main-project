<?php

namespace App\Form\ShopAddress;

use App\Lib\Form\ABaseForm;
use App\Repository\ShopRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetShopAddressesForm extends ABaseForm
{
    public function __construct(
        private readonly ShopRepository $shopRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): Collection
    {
        $route = self::getRouteParams($request);
        $shop_id = $route["id"];
        $shop = $this->shopRepository
            ->find($shop_id);

        if (!$shop) {
            throw new BadRequestHttpException("invalid shop id");
        }

        return $shop->getAddresses();
    }
}