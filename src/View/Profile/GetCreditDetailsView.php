<?php

namespace App\View\Profile;

use App\Entity\CreditInfo;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetCreditDetailsView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(CreditInfo $creditInfo): array
    {
        return [
            "id" => $creditInfo->getId(),
            "card" => $creditInfo->getCard(),
            "IBAN" => $creditInfo->getIBAN(),
            "expires_at" => $creditInfo->getExpiresAt()
        ];
    }
}