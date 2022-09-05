<?php

namespace App\Form\Profile;

use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetAddressForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): array
    {
        $user_phone = $this->getUser()->getUserIdentifier();
        $user = $this->userRepository
            ->findOneBy(["phoneNumber" => $user_phone]);

        iF (!$user) {
            throw new BadRequestHttpException("JWT Token Expired");
        }

        return $user->getAddresses()->getValues();
    }
}