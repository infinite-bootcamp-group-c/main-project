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
                    new Assert\NotNull(),
                    new Assert\NotBlank()
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
                    new Assert\Type("digit")
                ],
                "longitude" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Type("digit")
                ]
            ]
        ];
    }

    public function execute(Request $request): Address
    {
        $form = self::getParams($request);

        $user_phone = $this->getUser()->getUserIdentifier();
        $user = $this->userRepository
            ->findOneBy(["phoneNumber" => $user_phone]);

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