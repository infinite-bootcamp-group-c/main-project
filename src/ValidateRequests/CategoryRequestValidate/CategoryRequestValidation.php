<?php

namespace App\ValidateRequests\CategoryRequestValidate;

use App\ValidateRequests\BaseValidateRequest;
use App\ValidateRequests\ImplementBasavalidateFunctions;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryRequestValidation extends BaseValidateRequest
{
    use ImplementBasavalidateFunctions;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(0)]
    public readonly ?int $shop_id;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 255)]
    public readonly ?string $title;
}