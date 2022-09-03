<?php

namespace App\Form\Profile;

use App\Entity\CreditInfo;
use App\Lib\Form\ABaseForm;
use App\Repository\CreditInfoRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class GetCreditDetailsForm extends ABaseForm
{
    public function __construct(
        private readonly CreditInfoRepository $creditInfoRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): CreditInfo
    {
        $form = self::getParams($request);
        $credit_id = $form["route"]["credit_id"];

        $credit = $this->creditInfoRepository
            ->find($credit_id);

        if (!$credit) {
            throw new BadRequestException();
        }

        return $credit;
    }
}