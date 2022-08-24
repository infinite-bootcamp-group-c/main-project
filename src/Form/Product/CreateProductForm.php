<?php

namespace App\Form\Product;

use App\Lib\Form\ABaseForm;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProductForm extends ABaseForm
{

    public function constraints(): array
    {
        return [
            'body' => [
                'categoryID' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'name' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern : '/^\w+/'
                        , message : 'Product name must contain only letters, numbers and underscores'),
                ],
                'price' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Type('decimal'),
                    new Assert\positive(),
                ],
                'quantity' => [
                    new Assert\NotBlank(),
                    new Assert\Type('integer'),
                    new Assert\Positive(),
                ],
                'description' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 150, max: 1000),
                    new Assert\Regex(pattern : '/^\w+/', message : 'Description must contain only letters, numbers and underscores'),
                ],
            ],
        ];
    }

    public function execute(): void
    {
        // TODO: Implement execute() method.
    }
}