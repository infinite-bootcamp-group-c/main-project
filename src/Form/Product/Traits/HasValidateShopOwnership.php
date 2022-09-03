<?php

namespace App\Form\Product\Traits;

use App\Entity\Category;
use App\Entity\Shop;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait HasValidateShopOwnership
{
    public function validateShopOwnership(Shop $shop, int $userId): void
    {
        if ($shop->getUser()->getId() !== $userId)
            throw new BadRequestHttpException('You are not allowed to modify product in this shop');
    }
}