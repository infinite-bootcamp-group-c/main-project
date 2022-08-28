<?php

namespace App\Lib\Controller;

use App\Lib\Form\IBaseForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    public function makeResponse(IBaseForm $form, Request $request): JsonResponse
    {
        $validation = $form->validate($request);
        if (count($validation))
            return $this->json(['errors' => $validation]);
        $jsonResult = $form->execute($request);
        return $this->json($jsonResult);
    }
}