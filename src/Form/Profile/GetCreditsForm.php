<?php

namespace App\Form\Profile;

use App\Lib\Form\ABaseForm;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class GetCreditsForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): Collection
    {
        $form = self::getParams($request);
        $user_id = $form["route"]["user_id"];

        $user = $this->userRepository
            ->find($user_id);

        if (!$user) {
            throw new BadRequestException();
        }

        return $user->getCreditInfos();
    }
}