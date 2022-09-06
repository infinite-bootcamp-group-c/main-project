<?php

namespace App\View\Payment;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class VerifyPaymentView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(array $verify): array
    {
        return $verify;
    }
}