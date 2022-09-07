<?php

namespace App\View\Order;

use App\Entity\Order;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetOrdersView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(array $orders): array
    {
        return array_map(function (Order $order) {
            return [
                "status" => $order->getStatus(),
                "shop" => $order->getShop(),
                "total_price" => $order->getTotalPrice(),
                "items_count" => $order->getItems()->count()
            ];
        }, $orders);
    }
}