<?php

namespace App\Form\Profile;

use App\Entity\Address;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class GetAddressDetailsForm extends ABaseForm
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
        $form = self::getParams($request);

        $addressId = $form["route"]["address_id"];
        $address = $this->addressRepository
            ->find($addressId);

        if (!$address) {
            throw new BadRequestException("invalid address id");
        }

        return $address;
    }
}