<?php

namespace App\Controller\Api;

use App\Form\Basket\AddToBasketForm;
use App\Form\Basket\RemoveFromBasketForm;
use App\Lib\Controller\BaseController;
use App\View\Basket\AddToBasketView;
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
    #[Route('/item', name: 'set_item', methods: ['PATCH'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function addToBasket(
        Request         $request,
        AddToBasketForm $addToBasketForm,
        AddToBasketView $addToeBasketView,
    ): JsonResponse
    {
        return $addToBasketForm->makeResponse($request, $addToeBasketView);
    }

    #[Route('/item', name: 'delete_item', methods: ['DELETE'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function deleteItem(
        Request         $request,
        RemoveFromBasketForm $removeFromBasketForm,
    ): JsonResponse
    {
        return $removeFromBasketForm->makeResponse($request);
    }
}