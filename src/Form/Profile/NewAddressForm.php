<?php

namespace App\Form\Profile;

use App\Entity\Address;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class NewAddressForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly AddressRepository $addressRepository,
    ) {

    }

    public function constraints(): array
    {
        // TODO: Implement constraints() method.
        return [];
    }

    public function execute(Request $request): Address
    {
        $form = self::getParams($request);

        $userId = $form["body"]["user_id"];

        $user = $this->userRepository
            ->find($userId);

        if (!$user) {
            throw new BadRequestException("Invalid user");
        }

        $address = (new Address())
            ->setTitle($form["body"]["title"])
            ->setPostalCode($form["body"]["postal_code"])
            ->setProvince($form["body"]["province"])
            ->setAddressDetails($form["body"]["address_details"])
            ->setCountry($form["body"]["country"])
            ->setLatitude($form["body"]["latitude"])
            ->setLongitude($form["body"]["longitude"]);

        $user->addAddress($address);

        $this->addressRepository->flush();
        $this->userRepository->flush();

        return $address;
    }
}