<?php

namespace App\Form\Profile;

use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class GetAddressForm extends ABaseForm
{
    public function __construct(
        private readonly AddressRepository $addressRepository,
        private readonly UserRepository $userRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): Collection
    {
        $form = self::getParams($request);

        $userId = $form["route"]["user_id"];
        $user = $this->userRepository->find($userId);

        iF (!$user) {
            throw new BadRequestException("Invalid user id");
        }

        return $user->getAddresses();
    }
}