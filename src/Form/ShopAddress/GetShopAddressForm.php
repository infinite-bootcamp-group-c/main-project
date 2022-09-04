<?php

namespace App\Form\ShopAddress;

use App\Entity\Address;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class GetShopAddressForm extends ABaseForm
{
    public function __construct(
        private readonly AddressRepository $addressRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ]
            ]
        ];
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