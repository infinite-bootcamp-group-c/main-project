<?php

namespace App\ValidateRequests\OrderRequestValidate;

use App\ValidateRequests\BaseValidateRequest;
use App\ValidateRequests\ImplementBasavalidateFunctions;
use Symfony\Component\Validator\Constraints as Assert;

class OrderRequestValidation extends BaseValidateRequest
{
    use ImplementBasavalidateFunctions;

    #[Assert\NotBlank]
    #[Assert\Choice(['open', 'waiting', 'paid', 'sent', 'received'])]
    public readonly ?string $status;

    #[Assert\NotBlank]
    #[Assert\Type('decimal')]
    #[Assert\GreaterThanOrEqual(0)]
    public readonly ?int $total_price;
}