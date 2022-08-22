<?php

namespace App\ValidateRequests\ShopRequestValidate;

use App\ValidateRequests\BaseValidateRequest;
use App\ValidateRequests\ImplementBasavalidateFunctions;
use Symfony\Component\Validator\Constraints as Assert;

class ShopRequestValidation extends BaseValidateRequest
{
    use ImplementBasavalidateFunctions;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 255)]
    #[Assert\Regex(pattern : '/^\w+/',
        message : 'Shop name must start with word character')]
    public readonly ?string $name;

    #[Assert\Length(min: 3, max: 30)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$',
        message: 'The instagram username must be a valid instagram username')]
    public readonly ?string $ig_username;

    #[Assert\NotBlank]
    public readonly ?string $logo_url;

    #[Assert\Length(min: 150, max: 1000)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern : '/^\w+/',
        message : 'Description must start with word character')]
    public readonly ?string $description;
}