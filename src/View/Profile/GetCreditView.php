<?php

namespace App\View\Profile;

use App\Entity\Address;
use App\Entity\CreditInfo;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetCreditView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(array $credits): array
    {
        return array_map(function (CreditInfo $creditInfo) {
            return [
                "id" => $creditInfo->getId(),
                "card_no" => $creditInfo->getCard(),
                "expires_at" => $creditInfo->getExpiresAt()
            ];
        }, $credits);
    }
}