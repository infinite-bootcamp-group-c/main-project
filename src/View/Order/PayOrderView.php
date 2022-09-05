<?php

namespace App\View\Order;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class PayOrderView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(): array
    {

    }
}