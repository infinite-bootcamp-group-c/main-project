<?php

namespace App\Lib\View;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Lib\View\IBaseView;

abstract class ACreateView implements IBaseView
{
    abstract protected function createObject(array $form): array;
    abstract public function execute(array $params): static;
}