<?php

namespace App\Controller\Api;

use App\Form\User\RegisterUserForm;
use App\Lib\Controller\BaseController;
use App\View\User\RegisterUserView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
#[Tag(name: 'User', description: 'User operations')]
class UserController extends BaseController
{
    #[Route('/register', name: 'register_user', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function new(
        Request           $request,
        RegisterUserForm $registerUserForm,
        RegisterUserView $registerUserView
    ): JsonResponse
    {
        return $registerUserForm->makeResponse($request, $registerUserView);
    }

}
