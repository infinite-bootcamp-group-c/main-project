<?php

namespace App\Form\Order;

use App\Entity\Enums\OrderStatus;
use App\Form\Traits\HasOrderOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class ConfirmOrderForm extends ABaseForm
{
    use HasOrderOwnership;

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderItemRepository $orderItemRepository,
        private readonly AddressRepository $addressRepository,
        private readonly ProductRepository $productRepository
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
        $body = self::getBodyParams($request);
        $order_id = $body["id"];
        $address_id = $body["address_id"];

        $user_id = $this->getUser()->getId();
//        dd($user_id);
        $order = $this->orderRepository
            ->find($order_id);

        $address = $this->addressRepository
            ->find($address_id);

        if (!$order) {
            throw new BadRequestHttpException("Order {$order_id} Not Found");
        }
        $this->validateOwnership($order, $user_id);

        if (!$address) {
            throw new BadRequestHttpException("Address {$address_id} Not Found");
        }

        $orderItems = $this->orderItemRepository
            ->findBy(["order_id" => $order_id]);

        $total_price = 0;
        foreach ($orderItems as $orderItem) {
            $total_price += $orderItem->getUnitPrice() * $orderItem->getQuantity();

            // check if product is still available
            $product = $orderItem->getProduct();
            if ($product->getQuantity() < $orderItem->getQuantity()) {
                throw new BadRequestHttpException("Product Is Not Available");
            } else {
                $product->setQuantity($product->getQuantity() - $orderItem->getQuantity());
            }
        }

        $order->setTotalPrice($total_price);
        $order->setStatus(OrderStatus::WAITING);
        $order->setAddress($address);

        $this->productRepository->flush();
        $this->orderItemRepository->flush();
        $this->orderRepository->flush();

        return $order;
    }
}