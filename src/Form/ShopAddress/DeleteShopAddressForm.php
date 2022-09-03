<?php

namespace App\Form\ShopAddress;

use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeleteShopAddressForm extends ABaseForm
{
    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly AddressRepository $addressRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): String
    {
        $route = self::getRouteParams($request);
        $shop_id = $route["shop_id"];
        $address_id = $route["address_id"];
        $address = $this->addressRepository
            ->find($address_id);
        $shop = $this->shopRepository
            ->find($shop_id);

        if (!$address) {
            throw new BadRequestHttpException("invalid address id");
        }

        if (!$shop) {
            throw new BadRequestHttpException("invalid shop id");
        }

        $shop->removeAddress($address);
        $this->addressRepository->remove($address);
        $this->shopRepository->flush();
        $this->addressRepository->flush();

        return "Address Removed";
    }
}