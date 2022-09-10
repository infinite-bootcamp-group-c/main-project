<?php

namespace App\Form\Profile;

use App\Form\Traits\HasAddressOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteAddressForm extends ABaseForm
{
    use HasAddressOwnership;

    public function __construct(
        private readonly AddressRepository $addressRepository,
        private readonly UserRepository $userRepository
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
                    new Assert\Type('digit'),
                ]
            ]
        ];
    }

    public function execute(Request $request): void
    {
        $form = self::getParams($request);
        $user_phone = $this->getUser()->getUserIdentifier();
        $addressId = $form["route"]["id"];
        $address = $this->addressRepository->find($addressId);
        $user = $this->userRepository
            ->findOneBy(["phoneNumber" => $user_phone]);

        if (!$address) {
            throw new BadRequestHttpException("Address {$addressId} Not Found");
        }

        if (!$user) {
            throw new BadRequestHttpException("JWT Token Expired");
        }

        $this->validateOwnership($address,$user);

        $user->removeAddress($address);
        $this->addressRepository->remove($address);
        $this->userRepository->flush();
        $this->addressRepository->flush();
    }
}