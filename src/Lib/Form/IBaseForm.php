<?php

namespace App\Lib\Form;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface IBaseForm{
    public function constraints();
    public function validate(Request $request, ValidatorInterface $validator): void;
    public static function getQueryParams(Request $request): array;
    public static function getBodyParams(Request $request): array;
    public static function getRouteParams(Request $request): array;
    public static function getParams(Request $request): array;
    public function execute(Request $request): void;
}