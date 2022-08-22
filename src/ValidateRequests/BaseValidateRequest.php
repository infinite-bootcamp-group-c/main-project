<?php

namespace App\ValidateRequests;

use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseValidateRequest
{
    public function __construct(array $requestFields, ValidatorInterface $validator)
    {
        $this->fillProperties($requestFields);
        $this->validate($validator);
    }

    public function validate(ValidatorInterface $validator)
    {
        $errors = $validator->validate($this);

        if($errors->count()) {
            throw new \Exception();
        }
    }

    abstract protected function fillProperties(array $requestFields): void;
}