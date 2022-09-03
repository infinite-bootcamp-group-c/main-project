<?php

namespace App\Form\ShopAddress;

use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetShopAddressForm extends ABaseForm
{
    public function __construct(
        private readonly AddressRepository $addressRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): Address
    {
        $route = self::getRouteParams($request);
        $address_id = $route["id"];
        $address = $this->addressRepository
            ->find($address_id);

        if (!$address) {
            throw new BadRequestHttpException("invalid address id");
        }

        return $address;
    }
}