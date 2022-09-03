<?php

namespace App\View\Profile;

use App\Entity\Address;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetCreditView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(array $credits): array
    {
        return array_map(function (Address $creditInfo) {
            return [
                "id" => $creditInfo->getId(),
                "expires_at" => $creditInfo->setExpiresAt()
            ];
        }, $credits);
    }
}