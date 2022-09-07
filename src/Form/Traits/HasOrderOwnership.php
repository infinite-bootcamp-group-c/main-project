<?php

namespace App\Form\Traits;

use App\Entity\Order;
use App\Entity\Shop;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait HasOrderOwnership
{
    public function validateOwnership(Order $order, int $userId): void
    {
        if ($order->getUser()->getId() !== $userId)
            throw new BadRequestHttpException('You are not the owner of this order.');
    }
}