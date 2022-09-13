<?php

namespace App\Form\Profile;

use App\Entity\Address;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class GetAddressDetailsForm extends ABaseForm
{
    public function __construct(
        private readonly AddressRepository $addressRepository
    )
    {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ]
            ]
        ];
    }

    public function execute(array $form): Address
    {
        $addressId = $form["route"]["id"];
        $address = $this->addressRepository
            ->find($addressId);

        if (!$address) {
            throw new BadRequestHttpException("Address $addressId Not Found");
        }

        return $address;
    }
}
