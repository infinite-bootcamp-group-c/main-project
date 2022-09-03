<?php

namespace App\View\Profile;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetAddressDetailsView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(Address $address): array
    {
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
    }
}