<?php

namespace App\View\Order;

use App\Entity\Order;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class ConfirmOrderView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(Order $order): array
    {
        return [
            "order_id" => $order->getId(),
            "total_price" => $order->getTotalPrice(),
            "status" => $order->getStatus(),
            "shop" => $order->getShop(),
            "address" => $order->getAddresses()
        ];
    }
}