<?php

namespace App\Form\Shop;

use App\Lib\Form\ABaseForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateShopForm extends ABaseForm
{

    public function constraints(): array
    {
        return [
            'body' => [
                'name' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'Shop name must contain only letters, numbers and underscores'),
                ],
                'user_id' => [
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'ig_username' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 3, max: 30),
                    new Assert\Regex(pattern: '^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$'
                        , message: 'IG username must contain only letters, numbers and underscores'),
                ],
                'logo_url' => [
                    new Assert\Regex('/^\w+\.png/', "wrong pattern for shop logo image url"),
                ],
                'description' => [
                    new Assert\Length(max:255, maxMessage: "description must be 255 characters at most."),
                ],
            ],
        ];
    }

    public function execute(Request $request): void
    {
        // TODO: Implement execute() method.
    }
}