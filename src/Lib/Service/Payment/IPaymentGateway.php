<?php

namespace App\Lib\Service\Payment;

interface IPaymentGateway
{
    public function getConfigName(): string;

    public function request($amount, array $params, $callbackUrl, $description): array;

    public function verify($amount, $authority): array;
}