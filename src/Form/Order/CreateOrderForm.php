<?php

namespace App\Form\Order;

use App\Lib\Form\ABaseForm;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class CreateOrderForm extends ABaseForm
{

    public function constraints(): array
    {
        return [
            'body' => [
                'status' => [
                    new Assert\NotBlank(),
                    new Assert\Choice(choices: ['open', 'waiting', 'paid', 'sent', 'received']),
                ],
                'total_price' => [
                    new Assert\NotBlank(),
                    new Assert\Type('decimal'),
                    new Assert\positive(),
                ],
            ],
        ];
    }

    public function execute(Request $request): void
    {
        // TODO: Implement execute() method.
    }
}