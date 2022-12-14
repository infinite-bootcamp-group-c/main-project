<?php

namespace App\Form\Order;

use App\Entity\Enums\OrderTransactionStatus;
use App\Entity\OrderTransaction;
use App\Lib\Form\ABaseForm;
use App\Lib\Service\Payment\PaymentGatewayFactory;
use App\Repository\OrderRepository;
use App\Repository\OrderTransactionRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class PayOrderForm extends ABaseForm
{
    public function __construct(
        private readonly OrderRepository            $orderRepository,
        private readonly PaymentGatewayFactory      $paymentGatewayFactory,
        private readonly OrderTransactionRepository $orderTransactionRepository
    )
    {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "order_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ]
            ]
        ];
    }

    public function execute(array $form)
    {
        $route = $form["route"];
        $order_id = $route["order_id"];
        $order = $this->orderRepository
            ->find($order_id);

        if (!$order) {
            throw new BadRequestHttpException("Order $order_id Not Found");
        }

        $payment_method = "zarinpal";
        $order_transaction = (new OrderTransaction())
            ->setAmount($order->getTotalPrice())
            ->setStatus(OrderTransactionStatus::WAITING)
            ->setOrder($order)
            ->setPaymentMethod($payment_method);
        $this->orderTransactionRepository->add($order_transaction);
        $this->orderTransactionRepository->flush();
        $payment = $this->paymentGatewayFactory->get($payment_method)->request(
            amount: $order->getTotalPrice(),
            params: [
                "order_id" => $order_id,
                "order_transaction_id" => $order_transaction->getId()
            ],
        );

        if ($payment["result"] == "warning") {
            throw new BadRequestHttpException($payment["error"]);
        }

        return $payment["url"];
    }
}
