<?php

namespace App\Lib\Service\Payment;

use App\Lib\Service\Payment\Gateway\ZarinpalPayment;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PaymentGatewayFactory
{
    public array $gateway = [
        'zarinpal' => ZarinpalPayment::class
    ];

    public function __construct(
        public ContainerBagInterface $params,
        public HttpClientInterface   $httpClient
    )
    {
    }

    /**
     * @throws Exception
     */
    public function get(string $gatewayName): object
    {
        if (!isset($this->gateway[$gatewayName]))
            throw new Exception('Gateway not defined');

        $paymentMethod = $this->gateway[$gatewayName];

        if (!class_exists($paymentMethod))
            throw new Exception('Gateway not found');

        if (!is_subclass_of($paymentMethod, APaymentGateway::class))
            throw new Exception('Gateway not implemented APaymentGateway');


        return new $paymentMethod(
            params: $this->params,
            httpClient: $this->httpClient
        );
    }
}
