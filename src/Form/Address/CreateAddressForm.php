<?php

namespace App\Form\Address;

use App\Lib\Form\ABaseForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateAddressForm extends ABaseForm
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
                'province' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                ],
                'city' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                ],
                'postal_code' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '^(?!(\d)\1{3})[13-9]{4}[1346-9][ -]?[013-9]{5}$|^$'
                        , message: 'Postal code must be a valid postal code'),
                ],
                'country' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                ],
                'address_detail' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'Shop name must start with word character'),
                ],
                'latitude' => [
                    new Assert\NotBlank(),
                    new Assert\Type('decimal'),
                ],
                'longitude' => [
                    new Assert\NotBlank(),
                    new Assert\Type('decimal'),
                ],
            ],
        ];
    }

    public function execute(array $form): void
    {
        // TODO: Implement execute() method.
    }
}
