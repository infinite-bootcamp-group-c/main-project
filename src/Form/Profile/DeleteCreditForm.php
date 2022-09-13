<?php

namespace App\Form\Profile;

use App\Lib\Form\ABaseForm;
use App\Repository\CreditInfoRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteCreditForm extends ABaseForm
{
    public function __construct(
        private readonly CreditInfoRepository $creditInfoRepository,
        private readonly UserRepository       $userRepository
    )
    {

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

    public function execute(array $form): void
    {
        $credit_id = $form["route"]["id"];

        $credit = $this->creditInfoRepository
            ->find($credit_id);

        if (!$credit_id) {
            throw new BadRequestHttpException("CreditInfo $credit_id Not Found");
        }

        $user = $credit->getUser();

        $user->removeCreditInfo($credit);
        $this->creditInfoRepository
            ->remove($credit);

        $this->creditInfoRepository->flush();
        $this->userRepository->flush();
    }
}
