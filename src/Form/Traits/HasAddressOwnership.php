<?php

namespace App\Form\Traits;

use App\Entity\Address;
use App\Entity\Order;
use App\Entity\User;
use App\Repository\AddressRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait HasAddressOwnership
{
    public function validateOwnership(Address $address, User $user): void
    {
        $user_addresses = $user->getAddresses();
        if (!$user_addresses->contains($address))
        {
            throw new BadRequestHttpException("You're not the owner of this address");
        }
    }
}