<?php

namespace App\Form\Traits;


use App\Entity\Shop;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait HasValidateOwnership
{
    public function validateOwnership(Shop $shop, int $userId): void
    {
        if ($shop->getUser()->getId() !== $userId)
            throw new BadRequestHttpException('You are not the owner of this shop.');
    }
}