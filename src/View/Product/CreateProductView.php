<?php

namespace App\View\Product;

use App\Entity\User;
use App\Lib\View\ACreateView;
use Symfony\Component\HttpFoundation\Request;

class CreateProductView extends ACreateView
{

    protected function createObject(array $form): array
    {
        // TODO: Implement getData() method.
        return [];
    }

    public function execute(array $params): static
    {
        // TODO: Implement getData() method.
        return new static();
    }
}