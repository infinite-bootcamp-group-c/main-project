<?php

namespace App\Form\ShopAddress;

use App\Entity\Address;
use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class NewShopAddressForm extends ABaseForm
{
    use HasValidateOwnership;

    public function __construct(
        private readonly ShopRepository    $shopRepository,
        private readonly AddressRepository $addressRepository
    )
    {

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
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'The shop name {{ value }} is not valid.'),
                ],
                "postal_code" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Type("digit")
                ],
                "province" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()
                ],
                "address_details" => [
                ],
                "country" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()
                ],
                "city" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()
                ],
                "latitude" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
                "longitude" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ]
            ]
        ];
    }

    public function execute(array $form): Address
    {
        $form = $form["body"];
        $shop_id = $form["shop_id"];
        $shop = $this->shopRepository->find($shop_id);

        if (!$shop) {
            throw new BadRequestHttpException("Shop $shop_id Not Found");
        }

        $this->validateOwnership($shop, $this->getUser()->getId());

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
