<?php

namespace App\Controller\Api;

use App\Form\Product\DeleteProductForm;
use App\Form\Shop\CreateShopForm;
use App\Form\Shop\DeleteShopForm;
use App\Form\Shop\GetShopForm;
use App\Form\Shop\GetShopListForm;
use App\Form\Shop\UpdateShopForm;
use App\View\Shop\CreateShopView;
use App\View\Shop\GetShopListView;
use App\View\Shop\GetShopView;
use App\View\Shop\UpdateShopView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shops')]
#[Tag(name: 'Shop', description: 'shops operations')]
class ShopController extends AbstractController
{
    #[Route('/', name: 'get_shop_list', methods: ['GET'])]
    public function getList(
        Request         $request,
        GetShopListForm $getShopListForm,
        GetShopListView $getShopListView
    ): JsonResponse
    {
        return $getShopListForm->makeResponse($request, $getShopListView);
    }

    #[Route('/{id}', name: 'get_shop', methods: ['GET'])]
    public function get(
        Request     $request,
        GetShopForm $getShopForm,
        GetShopView $getShopView
    ): JsonResponse
    {
        return $getShopForm->makeResponse($request, $getShopView);
    }

    #[Route('/', name: 'create_shop', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function new(
        Request        $request,
        CreateShopForm $createShopForm,
        CreateShopView $createShopView
    ): JsonResponse
    {
        return $createShopForm->makeResponse($request, $createShopView);
    }

    #[Route('/{id}', name: 'update_shop', methods: ['PATCH'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function update(
        Request        $request,
        UpdateShopForm $updateShopForm,
        UpdateShopView $updateShopView
    ): JsonResponse
    {
        return $updateShopForm->makeResponse($request, $updateShopView);
    }

    #[Route('/{id}', name: 'delete_shop', methods: ['DELETE'])]
    public function delete(
        Request           $request,
        DeleteShopForm $deleteShopForm,
    ): JsonResponse
    {
        return $deleteShopForm->makeResponse($request);
    }
}
