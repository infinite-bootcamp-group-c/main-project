<?php

namespace App\ValidateRequests;

trait ImplementBasavalidateFunctions
{
    protected function fillProperties(array $fields): void
    {
        foreach ($fields as $field => $value) {
            if (property_exists($this, $field)) {
                $this->{$field} = $value;
            }
        }
    }
}