<?php

namespace App\Form\ShopAddress;

use App\Entity\Address;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class NewShopAddressForm extends ABaseForm
{
    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly AddressRepository $addressRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "body" => [
                "shop_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit')
                ],
                "title" => [

                ],
                "postal_code" => [

                ],
                "province" => [

                ],
                "address_details" => [

                ],
                "country" => [

                ],
                "city" => [

                ],
                "latitude" => [

                ],
                "longitude" => [

                ]
            ]
        ];
    }

    public function execute(Request $request): Address
    {
        $form = self::getBodyParams($request);

        $shop_id = $form["shop_id"];
        $shop = $this->shopRepository
            ->find($shop_id);

        if (!$shop) {
            throw new BadRequestHttpException("invalid shop id");
        }

        $address = (new Address())
            ->setTitle($form["title"])
            ->setPostalCode($form["postal_code"])
            ->setProvince($form["province"])
            ->setAddressDetails($form["address_details"])
            ->setCountry($form["country"])
            ->setCity($form["city"])
            ->setLatitude($form["latitude"])
            ->setLongitude($form["longitude"]);

        $this->addressRepository->add($address);
        $shop->addAddress($address);
        $this->addressRepository->flush();
        $this->shopRepository->flush();

        return $address;
    }
}