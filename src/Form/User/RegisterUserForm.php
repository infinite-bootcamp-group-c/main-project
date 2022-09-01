<?php

namespace App\Form\User;

use App\Entity\User;
use App\Lib\Form\ABaseForm;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function constraints(): array
    {
        return [
            'body' => [
                'firstName' => [
                    new Assert\Length(max: 255),
                    new Assert\Regex(pattern: '/^[a-zA-Z0-9]+$/')
                ],
                'lastName' => [
                    new Assert\Length(max: 255),
                    new Assert\Regex(pattern: '/^[a-zA-Z0-9]+$/')
                ],
                'email' => [
                    new Assert\Length(max: 255),
                    new Assert\Email(message: 'The email {{ value }} is not valid email.')
                ],
                'phoneNumber' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 11, max: 15),
                    new Assert\Regex(pattern: '/^[\+|09]\d{1,15}$/',
                        message: 'The phone number {{ value }} is not valid phone number'),
                ],
                'password' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 8, max: 24)
                ],
            ],
        ];
    }

    public function execute(Request $request): User
    {
        $form = self::getParams($request);

        $user = (new User($this->passwordHasher))
            ->setPhoneNumber($form["body"]["phoneNumber"])
            ->setPassword($form["body"]["password"]);

        if(isset($form["body"]["firstName"])) {
            $user->setFirstName($form["body"]["firstName"]);
        }

        if(isset($form["body"]["lastName"])) {
            $user->setLastName($form["body"]["lastName"]);
        }

        if(isset($form["body"]["email"])) {
            $user->setEmail($form["body"]["email"]);
        }

        $this->userRepository->add($user, flush: true);
        return $user;
    }
}