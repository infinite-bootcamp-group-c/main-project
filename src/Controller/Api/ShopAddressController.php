<?php

namespace App\Controller\Api;

use App\Lib\Controller\BaseController;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop_address')]
#[Tag(name: 'Profile', description: 'Profile operations')]
class ShopAddressController extends BaseController
{
    #[Route("/{id}", name: 'get_shop_addresses', methods: ['GET'])]
    public function getAll(
        Request $request,
        GetShopAddressesForm $getShopAddressesForm,
        GetShopAddressesView $getShopAddressesView
    ): JsonResponse {
        return $getShopAddressesForm->makeResponse($request,$getShopAddressesView);
    }

    // shop id
    #[Route("/{id}", name: 'get_shop_address', methods: ['GET'])]
    public function get(
        Request $request,
        GetShopAddressForm $getShopAddressForm,
        GetShopAddressView $getShopAddressView
    ): JsonResponse {
        return $getShopAddressForm->makeResponse($request,$getShopAddressView);
    }

    #[Route("/", name: 'new_shop_address', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function post(
        Request $request,
        NewShopAddressForm $newShopAddressForm,
        NewShopAddressView $newShopAddressView
    ): JsonResponse {
        return $newShopAddressForm->makeResponse($request,$newShopAddressView);
    }

    // shop id
    #[Route("/{id}", name: 'delete_shop_address', methods: ['DELETE'])]
    public function delete(
        Request $request,
        DeleteShopAddressForm $deleteShopAddressForm,
        DeleteShopAddressView $deleteShopAddressView
    ): JsonResponse {
        return $deleteShopAddressForm->makeResponse($request,$deleteShopAddressView);
    }
}