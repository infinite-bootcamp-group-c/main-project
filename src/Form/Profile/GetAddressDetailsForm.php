<?php

namespace App\Form\Profile;

use App\Entity\Address;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetAddressDetailsForm extends ABaseForm
{
    public function __construct(
        private readonly AddressRepository $addressRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "address_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ]
            ]
        ];
    }

    public function execute(Request $request): Address
    {
        $form = self::getParams($request);

        $addressId = $form["route"]["address_id"];
        $address = $this->addressRepository
            ->find($addressId);

        if (!$address) {
            throw new BadRequestHttpException("invalid address id");
        }

        return $address;
    }
}