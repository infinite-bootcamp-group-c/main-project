<?php

namespace App\ValidateRequests\AddressRequestValidate;

use App\ValidateRequests\BaseValidateRequest;
use App\ValidateRequests\ImplementBasavalidateFunctions;
use Symfony\Component\Validator\Constraints as Assert;

class AddressRequestValidation extends BaseValidateRequest
{

    use ImplementBasavalidateFunctions;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 255)]
    public readonly ?string $title;

    #[Assert\NotBlank]
    #[Assert\length(min: 4, max: 255)]
    #[Assert\Regex(pattern : '^(?!(\d)\1{3})[13-9]{4}[1346-9][ -]?[013-9]{5}$|^$',
        message : 'Postal code must be a valid postal code')]
    public readonly ?string $postal_code;

    #[Assert\NotBlank]
    #[Assert\length(min: 4, max: 255)]
    public readonly ?string $province;

    #[Assert\NotBlank]
    #[Assert\length(min: 4, max: 255)]
    public readonly ?string $city;

    #[Assert\NotBlank]
    #[Assert\length(min: 4, max: 255)]
    #[Assert\Regex(pattern : '/^\w+/',
        message : 'Shop name must start with word character')]
    public readonly ?string $address_detail;

    #[Assert\NotBlank]
    #[Assert\length(min: 4, max: 255)]
    public readonly ?string $country;

    #[Assert\NotBlank]
    #[Assert\Type('decimal')]
    public readonly ?string $latitude;

    #[Assert\NotBlank]
    #[Assert\Type('decimal')]
    public readonly ?string $longitude;
}