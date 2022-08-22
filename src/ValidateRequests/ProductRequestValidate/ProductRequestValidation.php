<?php

namespace App\ValidateRequests\ProductRequestValidate;

use App\ValidateRequests\BaseValidateRequest;
use App\ValidateRequests\ImplementBasavalidateFunctions;
use Symfony\Component\Validator\Constraints as Assert;

class ProductRequestValidation extends BaseValidateRequest
{

    use ImplementBasavalidateFunctions;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public readonly ?int $categoryID;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 255)]
    #[Assert\Regex(pattern : '/^\w+/',
        message : 'Shop name must start with word character')]
    public readonly ?string $name;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('decimal')]
    #[Assert\GreaterThanOrEqual(0)]
    public readonly ?int $price;

    #[Assert\GreaterThanOrEqual(0)]
    public readonly ?int $quantity;

    #[Assert\Length(min: 150, max: 1000)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern : '/^\w+/',
        message : 'Description must start with word character')]
    public readonly ?string $description;
}