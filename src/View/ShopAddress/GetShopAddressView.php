<?php

namespace App\View\ShopAddress;

use App\Entity\Address;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetShopAddressView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(Address $address): array
    {
        return [
            "id" => $address->getId(),
            "postal_code" => $address->getPostalCode(),
            "province" => $address->getProvince(),
            "city" => $address->getCity(),
            "address_details" => $address->getAddressDetails(),
            "country" => $address->getCountry(),
            "latitude" => $address->getLatitude(),
            "longitude" => $address->getLongitude(),
        ];
    }
}