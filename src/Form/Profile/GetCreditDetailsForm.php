<?php

namespace App\Form\Profile;

use App\Entity\CreditInfo;
use App\Lib\Form\ABaseForm;
use App\Repository\CreditInfoRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class GetCreditDetailsForm extends ABaseForm
{
    public function __construct(
        private readonly CreditInfoRepository $creditInfoRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ]
            ]
        ];
    }

    public function execute(Request $request): CreditInfo
    {
        $form = self::getParams($request);
        $credit_id = $form["route"]["id"];

        $credit = $this->creditInfoRepository
            ->find($credit_id);

        if (!$credit) {
            throw new BadRequestHttpException("invalid credit id");
        }

        return $credit;
    }
}