<?php

namespace App\Form;

use App\Lib\Form\ABaseForm;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProductForm extends ABaseForm
{
    public function constraints(): array
    {
        return [
            'body' => [
                'title' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length(min: 4, max: 255),
                ],
                'stock' => [
                    new Assert\NotNull(),
                    new Assert\PositiveOrZero(),
                ]
            ],
        ];
    }

    public function execute(): void
    {
        // TODO: Implement execute() method.
    }
}