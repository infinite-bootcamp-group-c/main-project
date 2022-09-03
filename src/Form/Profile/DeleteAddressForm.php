<?php

namespace App\Form\Profile;

use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeleteAddressForm extends ABaseForm
{
    public function __construct(
        private readonly AddressRepository $addressRepository,
        private readonly UserRepository $userRepository
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

    public function execute(Request $request): String
    {
        $form = self::getParams($request);
        $user_id = $form["route"]["user_id"];
        $addressId = $form["route"]["address_id"];
        $address = $this->addressRepository->find($addressId);
        $user = $this->userRepository->find($user_id);

        if (!$addressId) {
            throw new BadRequestHttpException("invalid address id");
        }

        if (!$user) {
            throw new BadRequestHttpException("invalid user id");
        }

        $user->removeAddress($address);
        $this->addressRepository->remove($address);
        $this->userRepository->flush();
        $this->addressRepository->flush();

        return "address removed";
    }
}