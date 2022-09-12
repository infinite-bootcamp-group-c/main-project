<?php

namespace App\Lib\Form;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface IBaseForm
{
    public function makeResponse(Request $request, ABaseView $view = null): JsonResponse;

}
