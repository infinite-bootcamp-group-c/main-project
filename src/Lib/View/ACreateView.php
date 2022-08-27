<?php

namespace App\Lib\View;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Lib\View\IBaseView;
use Symfony\Component\HttpFoundation\Response;

abstract class ACreateView implements IBaseView
{
    abstract protected function createObject(array $form);
    abstract public static function execute(array $params): void;
    abstract public function createResponse(array $responseArray): Response;
    public function toArray($entity): array
    {
        return (array) $entity;
    }
}