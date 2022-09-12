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
        private readonly UserRepository              $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public static function IranPhoneNumberNormalize(string $phoneNumber): string
    {
        if (str_starts_with($phoneNumber, "0098") || str_starts_with($phoneNumber, "+98")) {
            $phoneNumber = '0' . substr($phoneNumber, -10);
        }
        return $phoneNumber;
    }

    public function constraints(): array
    {
        return [
            'body' => [
                'first_name' => [
                    new Assert\Length(max: 255),
                    new Assert\Regex(pattern: '/^[a-zA-Z0-9]+$/')
                ],
                'last_name' => [
                    new Assert\Length(max: 255),
                    new Assert\Regex(pattern: '/^[a-zA-Z0-9]+$/')
                ],
                'email' => [
                    new Assert\Length(max: 255),
                    new Assert\Email(message: 'The email {{ value }} is not valid email.')
                ],
                'phone_number' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Regex(pattern: '/^(0098|\+98|0)9[0-3,9][0-9]{8}$/',
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
            ->setPhoneNumber(self::IranPhoneNumberNormalize($form["body"]["phone_number"]))
            ->setPassword($form["body"]["password"])
            ->setRoles(['ROLE_USER']);

        if (isset($form["body"]["first_name"])) {
            $user->setFirstName($form["body"]["first_name"]);
        }

        if (isset($form["body"]["last_name"])) {
            $user->setLastName($form["body"]["last_name"]);
        }

        if (isset($form["body"]["email"])) {
            $user->setEmail($form["body"]["email"]);
        }

        $this->userRepository->add($user, flush: true);
        return $user;
    }
}
