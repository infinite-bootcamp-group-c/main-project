<?php

namespace App\Form\User;

use App\Entity\User;
use App\Lib\Form\ABaseForm;
use Symfony\Component\HttpFoundation\Request;

class GetUserForm extends ABaseForm
{
    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): User
    {
        return $this->getUser();
    }
}