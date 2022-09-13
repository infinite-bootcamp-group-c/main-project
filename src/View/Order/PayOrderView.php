<?php

namespace App\View\Order;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class PayOrderView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_ACCEPTED;

    public function execute($redirect_url): array
    {
        return [
            "redirect_url" => $redirect_url,
        ];
    }
}
