<?php

namespace App\Controller\Api;

use App\Form\Basket\AddToBasketForm;
use App\Form\Basket\GetCurrentBasketForm;
use App\Form\Basket\RemoveFromBasketForm;
use App\Lib\Controller\BaseController;
use App\View\Basket\AddToBasketView;
use App\View\Basket\GetCurrentBasketView;
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
        Request              $request,
        RemoveFromBasketForm $removeFromBasketForm,
    ): JsonResponse
    {
        return $removeFromBasketForm->makeResponse($request);
    }

    #[Route('/{shop_id}', name: 'get_current_basket', methods: ['GET'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function getCurrentBasket(
        Request              $request,
        GetCurrentBasketForm $getCurrentBasketForm,
        GetCurrentBasketView $currentBasketView
    ): JsonResponse
    {
        return $getCurrentBasketForm->makeResponse($request, $currentBasketView);
    }
}
