<?php

namespace App\Form\Order;

use App\Entity\Enums\OrderStatus;
use App\Lib\Form\ABaseForm;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class ConfirmOrderForm extends ABaseForm
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderItemRepository $orderItemRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "body" => [
                "order_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ],
                "address_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ]
            ]
        ];
    }

    public function execute(Request $request)
    {
        $route = self::getRouteParams($request);
        $order_id = $route["id"];

        $order = $this->orderRepository
            ->find($order_id);

        if (!$order) {
            throw new BadRequestHttpException("invalid order id");
        }

        $orderItems = $this->orderItemRepository
            ->findBy(["order_id" => $order_id]);

        $total_price = 0;
        foreach ($orderItems as $orderItem) {
            $total_price += $orderItem->getUnitPrice() * $orderItem->getQuantity();

            // check if product is still available
            $product = $orderItem->getProduct();
            if ($product->getQuantity() < $orderItem->getQuantity()) {
                throw new BadRequestHttpException("product not available");
            } else {
                $product->setQuantity($product->getQuantity() - $orderItem->getQuantity());
            }
        }

        $order->setTotalPrice($total_price);
        $order->setStatus(OrderStatus::WAITING);

        $this->orderItemRepository->flush();
        $this->orderRepository->flush();

        return $order;
    }
}