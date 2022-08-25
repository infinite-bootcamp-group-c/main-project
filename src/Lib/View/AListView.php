<?php
namespace App\Lib\View;

use App\Entity\User;
use App\Lib\View\IBaseView;
use Symfony\Component\HttpFoundation\Request;

abstract class AListView implements IBaseView
{
    abstract protected function getData(array $form): array;
    abstract public static function execute(array $params): void;
}