<?php

namespace App\Form\Order;

use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\OrderRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class SelectAddressForm extends ABaseForm
{
    public function __construct(
        private readonly AddressRepository $addressRepository,
        private readonly OrderRepository   $orderRepository
    )
    {

    }

    public function constraints(): array
    {
        return [
            "body" => [
                "order_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("integer")
                ],
                "address_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("integer")
                ]
            ]
        ];
    }

    public function execute(array $form): void
    {
        $body = $form["body"];
        $order_id = $body["order_id"];
        $address_id = $body["address_id"];

        $order = $this->orderRepository
            ->find($order_id);
        if (!$order) {
            throw new BadRequestHttpException("Order id $order_id not found");
        }

        $address = $this->addressRepository
            ->find($address_id);
        if (!$address) {
            throw new BadRequestHttpException("Address id $address_id not found");
        }

        $order->setAddress($address);
        $this->orderRepository->flush();
    }
}
