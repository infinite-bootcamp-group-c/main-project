<?php

namespace App\Form\Shop;

use App\Lib\Form\ABaseForm;
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
                    new Assert\Regex(pattern : '/^\w+/'
                        , message : 'Shop name must contain only letters, numbers and underscores'),
                ],
                'ig_username' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 3, max: 30),
                    new Assert\Regex(pattern : '^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$'
                        , message : 'IG username must contain only letters, numbers and underscores'),
                ],
                'logo_url' => [
                    new Assert\NotBlank(),
                ],
                'description' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 150, max: 1000),
                    new Assert\Regex(pattern : '/^\w+/'
                        , message : 'Description must contain only letters, numbers and underscores'),
                ],
            ],
        ];
    }

    public function execute(): void
    {
        // TODO: Implement execute() method.
    }
}