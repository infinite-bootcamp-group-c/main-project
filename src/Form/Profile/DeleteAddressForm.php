<?php

namespace App\Form\Profile;

use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeleteAddressForm extends ABaseForm
{
    public function __construct(
        private readonly AddressRepository $addressRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): String
    {
        $form = self::getParams($request);
        $addressId = $form["route"]["address_id"];
        $address = $this->addressRepository->find($addressId);

        if (!$addressId) {
            throw new BadRequestHttpException("invalid address id");
        }

        $this->addressRepository->remove($address);
        $this->addressRepository->flush();

        return "address removed";
    }
}