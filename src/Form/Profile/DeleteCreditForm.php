<?php

namespace App\Form\Profile;

use App\Lib\Form\ABaseForm;
use App\Repository\CreditInfoRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeleteCreditForm extends ABaseForm
{
    public function __construct(
        private readonly CreditInfoRepository $creditInfoRepository,
        private readonly UserRepository $userRepository
    ) {

    }

    public function constraints(): array
    {
        return [
            "route" => [
                "credit_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ]
            ]
        ];
    }

    public function execute(Request $request): String
    {
        $form = self::getParams($request);
        $credit_id = $form["route"]["credit_id"];

        $credit = $this->creditInfoRepository
            ->find($credit_id);

        if (!$credit_id){
            throw new BadRequestHttpException("invalid credit id");
        }

        $user = $credit->getUser();

        $user->removeCreditInfo($credit);
        $this->creditInfoRepository
            ->remove($credit);

        $this->creditInfoRepository->flush();
        $this->userRepository->flush();

        return "Credit Card Removed";
    }
}