<?php

namespace App\Form\Profile;

use App\Entity\Address;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class NewAddressForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly AddressRepository $addressRepository,
    ) {

    }

    public function constraints(): array
    {
        return [
            "body" => [
                "user_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
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
        $form = self::getParams($request);

        $userId = $form["body"]["user_id"];

        $user = $this->userRepository
            ->find($userId);

        if (!$user) {
            throw new BadRequestHttpException("Invalid user");
        }

        $address = (new Address())
            ->setTitle($form["body"]["title"])
            ->setPostalCode($form["body"]["postal_code"])
            ->setProvince($form["body"]["province"])
            ->setAddressDetails($form["body"]["address_details"])
            ->setCountry($form["body"]["country"])
            ->setCity($form["body"]["city"])
            ->setLatitude($form["body"]["latitude"])
            ->setLongitude($form["body"]["longitude"]);

        $this->addressRepository->add($address);

        $user->addAddress($address);
        $this->userRepository->flush();
        $this->addressRepository->flush();

        return $address;
    }
}