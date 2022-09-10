<?php

namespace App\View\Basket;

use App\Lib\View\ABaseView;
use App\Entity\Order;
use App\Entity\OrderItem;
use Symfony\Component\HttpFoundation\Response;

class AddToBasketView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(array $entities): array
    {
        $order = $entities["order"];
        $oderItem = $entities["orderItem"];

        return [
            "orderId" => $order->getId(),
            "orderItemId" => $oderItem->getId(),
        ];
    }
}