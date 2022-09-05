<?php

namespace App\View\ShopAddress;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class DeleteShopAddressView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(String $message): array
    {
        return [
            "message" => $message,
        ];
    }
}