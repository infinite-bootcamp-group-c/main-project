<?php

namespace App\Form\ShopAddress;

use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteShopAddressForm extends ABaseForm
{
    public function __construct(
        private readonly ShopRepository    $shopRepository,
        private readonly AddressRepository $addressRepository
    )
    {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "shop_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ],
                "address_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ]
            ]
        ];
    }

    public function execute(array $form): string
    {
        $route = $form["route"];
        $shop_id = $route["shop_id"];
        $address_id = $route["address_id"];
        $address = $this->addressRepository
            ->find($address_id);
        $shop = $this->shopRepository
            ->find($shop_id);

        if (!$address) {
            throw new BadRequestHttpException("Address $address_id Not Found");
        }

        if (!$shop) {
            throw new BadRequestHttpException("Shop $shop_id Not Found");
        }

        $shop->removeAddress($address);
        $this->addressRepository->remove($address);
        $this->shopRepository->flush();
        $this->addressRepository->flush();

        return "Address Removed";
    }
}
