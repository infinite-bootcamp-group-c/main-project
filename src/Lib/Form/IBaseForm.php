<?php

namespace App\Lib\Form;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

interface IBaseForm
{
    public static function getBodyParams(Request $request): array;

    public static function getQueryParams(Request $request): array;

    public static function getRouteParams(Request $request): array;

    public static function getParams(Request $request): array;

    public function getUser(): ?UserInterface;

    public function validate(Request $request): array;

    public function json(array $data, int $status = Response::HTTP_OK): JsonResponse;

    public function makeResponse(Request $request, ABaseView $view = null): JsonResponse;

    public function constraints();

    public function execute(Request $request);

}