<?php

namespace App\Form\User;

use App\Entity\User;
use App\Lib\Form\ABaseForm;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [
            'body' => [
                'first_name' => [
                    new Assert\Length(max: 255),
//                    new Assert\Regex(pattern: '/^[a-zA-Z]+$/',message: 'Not a valid first name')
                ],
                'last_name' => [
                    new Assert\Length(max: 255),
//                    new Assert\Regex(pattern: '/^[a-zA-Z]+$/'
//                        ,message: 'Not a valid first name')
                ],
                'email' => [
                    new Assert\Length(max: 255),
//                    new Assert\Regex(pattern: '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', message: 'Not a valid email address')
                ],
                'phone_number' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 13, max: 15),
                    new Assert\Regex(pattern: '/^[\+]\d{1,15}$/', message: 'Not a valid phone number'),
                ],
                'password' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 8, max: 24),
//                    new Assert\Regex(pattern: '^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$'
//                        , message: 'IG username must contain only letters, numbers and underscores'),
                ],
            ],
        ];
    }

    public function execute(Request $request): User
    {
        $form = self::getParams($request);

        $user = (new User())
            ->setPhoneNumber($form["body"]["phone_number"])
            ->setPassword($form["body"]["password"]);

        isset($form["body"]["first_name"]) && $user->setFirstName($form["body"]["first_name"]);
        isset($form["body"]["last_name"]) && $user->setLastName($form["body"]["last_name"]);
        isset($form["body"]["email"]) && $user->setEmail($form["body"]["email"]);

        $this->userRepository->add($user, flush: true);
        return $user;
    }
}