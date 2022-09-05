<?php

namespace App\Controller\Api;

use App\Lib\Controller\BaseController;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/basket')]
#[Tag(name: 'Basket', description: 'Basket operations')]
class BasketController extends BaseController
{
    #[Route('/add', name: 'add_new_item', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function addToBasket(
        Request         $request,
    ): JsonResponse
    {
        return new JsonResponse();
    }
}