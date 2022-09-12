<?php

namespace App\Form\User;

use App\Entity\User;
use App\Lib\Form\ABaseForm;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetUserForm extends ABaseForm
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

    public function execute(array $form): User
    {
        $auth_user = $this->getUser();
        $user_phone = $auth_user->getUserIdentifier();

        $user = $this->userRepository
            ->findOneBy(["phoneNumber" => $user_phone]);

        if (!$user) {
            throw new BadRequestHttpException("invalid user token");
        }

        return $user;
    }
}
