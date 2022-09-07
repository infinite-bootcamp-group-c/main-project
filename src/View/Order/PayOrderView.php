<?php

namespace App\View\Order;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class PayOrderView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_ACCEPTED;

    public function execute($reditect_url): array
    {
        return [
            "redirect_url" => $reditect_url,
        ];
    }
}