<?php

namespace App\Form\Payment;

use App\Entity\Enums\OrderStatus;
use App\Entity\Enums\OrderTransactionStatus;
use App\Lib\Form\ABaseForm;
use App\Lib\Service\Payment\PaymentGatewayFactory;
use App\Repository\OrderRepository;
use App\Repository\OrderTransactionRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class VerifyPaymentForm extends ABaseForm
{
    public function __construct(
        private readonly PaymentGatewayFactory      $paymentGatewayFactory,
        private readonly OrderRepository            $orderRepository,
        private readonly OrderTransactionRepository $orderTransactionRepository
    )
    {

    }

    public function constraints(): array
    {
        return [
            "query" => [
                "order_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ],
                "order_transaction_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ],
                "Authority" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ],
                "Status" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ]
        ];
    }


    public function execute(array $form): array
    {
        $route = $form["query"];
        $transaction_id = $route["order_transaction_id"];
        $order_id = $route["order_id"];
        $authority = $route["Authority"];

        $order = $this->orderRepository->find($order_id);
        if (!$order) {
            throw new BadRequestHttpException("Order {$order_id} Not Found");
        }

        $transaction = $this->orderTransactionRepository->find($transaction_id);

        if (!$transaction)
            throw new BadRequestHttpException("Transaction {$transaction_id} Not Found");

        $verify = $this->paymentGatewayFactory->get('zarinpal')->verify(
            amount: $order->getTotalPrice(),
            authority: $route['authority'],
        );

        if ($verify["result"] == 'success') {
            $order->setStatus(OrderStatus::PAID);
            $transaction->setPaymentVerificationCode($authority);
            $transaction->setStatus(OrderTransactionStatus::SUCCESS);
        } else {
            $order->setStatus(OrderStatus::WAITING);
            $transaction->setStatus(OrderTransactionStatus::FAILED);
        }

        $this->orderTransactionRepository->flush();
        $this->orderRepository->flush();

        return $verify;
    }
}
