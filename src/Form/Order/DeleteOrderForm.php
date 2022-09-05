<?php

namespace App\Form\Order;

use App\Entity\Enums\OrderStatus;
use App\Lib\Form\ABaseForm;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteOrderForm extends ABaseForm
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly ProductRepository $productRepository,
        private readonly OrderItemRepository $orderItemRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "id" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ]
            ]
        ];
    }

    public function execute(Request $request): String
    {
        // check if order is open
        // delete order items
        // add the quantity to products
        // delete order

        $order_id = self::getRouteParams($request);
        $order = $this->orderRepository
            ->find($order_id);

        if (!$order) {
            throw new BadRequestHttpException("invalid order id");
        }

        if ($order->getStatus() != OrderStatus::OPEN) {
            throw new BadRequestHttpException("order is not open, can not be deleted");
        }

        $order_items = $this->orderItemRepository
            ->findBy(["order_id" => $order_id]);

        foreach ($order_items as $order_item) {
            $product = $order_item->getProduct();

            $product->setQuantity($product->getQuantity() + $order_item->getQuantity());
            $this->orderItemRepository->remove($order_item);
        }

        $this->orderRepository->remove($order);

        return "Order Deleted";
    }
}