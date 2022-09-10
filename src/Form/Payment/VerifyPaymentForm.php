<?php

namespace App\Form\Payment;

use App\Entity\Enums\OrderStatus;
use App\Entity\Enums\OrderTransactionStatus;
use App\Lib\Form\ABaseForm;
use App\Lib\Service\Payment\PaymentGatewayFactory;
use App\Repository\OrderRepository;
use App\Repository\OrderTransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VerifyPaymentForm extends ABaseForm
{
    public function __construct(
        private readonly PaymentGatewayFactory $paymentGatewayFactory,
        private readonly OrderRepository $orderRepository,
        private readonly OrderTransactionRepository $orderTransactionRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "query" => [
                "order_id" => [

                ],
                "order_transaction_id" => [

                ],
                "Authority" => [

                ],
                "Status" => [

                ]
            ]
        ];
    }

    public function execute(Request $request): array
    {
        $route = self::getQueryParams($request);
        $transaction_id = $route["order_transaction_id"];
        $order_id = $route["order_id"];

        $order = $this->orderRepository->find($order_id);
        if (!$order) {
            throw new BadRequestHttpException("Order {$order_id} Not Found");
        }

        $transaction = $this->orderTransactionRepository->find($transaction_id);
        if (!$transaction) {
            throw new BadRequestHttpException("Transaction {$transaction_id} Not Found");
        }

        $verify = $this->paymentGatewayFactory->get('zarinpal')->verify(
            amount: $order->getTotalPrice(),
            authority: $request->get('Authority'),
        );

        if ($verify["result"] == 'success')
        {
            $order->setStatus(OrderStatus::PAID);
            $transaction->setStatus(OrderTransactionStatus::SUCCESS);
        }
        else
        {
            $order->setStatus(OrderStatus::WAITING);
            $transaction->setStatus(OrderTransactionStatus::FAILED);
        }

        $this->orderTransactionRepository->flush();
        $this->orderRepository->flush();

        return $verify;
    }
}