<?php

namespace App\View\User;

use App\Entity\User;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(User $user): array
    {
        return [
            'id' => $user->getId(),
            'phone_number' => $user->getPhoneNumber(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
        ];
    }
}