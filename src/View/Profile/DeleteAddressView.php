<?php

namespace App\View\Profile;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class DeleteAddressView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(String $message): array
    {
        return [
            "message" => $message
        ];
    }
}