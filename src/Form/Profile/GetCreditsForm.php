<?php

namespace App\Form\Profile;

use App\Lib\Form\ABaseForm;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetCreditsForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(array $form): array
    {
        $user_phone = $this->getUser()->getUserIdentifier();
        $user = $this->userRepository
            ->findOneBy(["phoneNumber" => $user_phone]);

        if (!$user) {
            throw new BadRequestHttpException("JWT Token Expired");
        }

        return $user->getCreditInfos()->getValues();
    }
}
