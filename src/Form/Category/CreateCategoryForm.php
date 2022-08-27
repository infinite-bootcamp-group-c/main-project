<?php

namespace App\Form\Category;

use App\Lib\Form\ABaseForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCategoryForm extends ABaseForm
{
    public function constraints(): array
    {
        return [
            'body' => [
                'shop_id' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'title' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'Category name must contain only letters, numbers and underscores'),
                ],
            ],
        ];
    }

    public function execute(Request $request): void
    {
        // TODO: Implement execute() method.
    }
}