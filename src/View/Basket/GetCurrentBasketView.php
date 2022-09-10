<?php

namespace App\View\Basket;

use App\Entity\Order;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetCurrentBasketView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_OK;

    public function execute(Order $order): array
    {
        $finalArray = [
            "order_id" => $order->getId(),
            "status" => $order->getStatus(),
            "total_price" => $order->getTotalPrice(),
        ];
        $items = $order->getItems();
        foreach ($items as $item) {
            $finalArray["items"][$item->getProduct()->getName()] = $item->getQuantity();
        }

        return $finalArray;
    }
}
