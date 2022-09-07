<?php

namespace App\View\Profile;

use App\Entity\Address;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetAddressView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(array $addresses): array
    {
        return array_map(function (Address $address) {
            return [
                "id" => $address->getId(),
                "title" => $address->getTitle(),
                "postal_code" => $address->getPostalCode(),
                "province" => $address->getProvince(),
                "city" => $address->getCity(),
                "address_details" => $address->getAddressDetails(),
                "country" => $address->getCountry(),
                "latitude" => $address->getLatitude(),
                "longitude" => $address->getLongitude(),
            ];
        }, $addresses);
    }
}