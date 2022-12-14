<?php

namespace App\Controller\Api;

use App\Form\ShopAddress\DeleteShopAddressForm;
use App\Form\ShopAddress\GetShopAddressesForm;
use App\Form\ShopAddress\GetShopAddressForm;
use App\Form\ShopAddress\NewShopAddressForm;
use App\Lib\Controller\BaseController;
use App\View\ShopAddress\DeleteShopAddressView;
use App\View\ShopAddress\GetShopAddressesView;
use App\View\ShopAddress\GetShopAddressView;
use App\View\ShopAddress\NewShopAddressView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop-address')]
#[Tag(name: 'Shop Address', description: 'Shop Address operations')]
class ShopAddressController extends BaseController
{
    #[Route("/all/{shop_id}", name: 'get_shop_addresses', methods: ['GET'])]
    public function getAll(
        Request              $request,
        GetShopAddressesForm $getShopAddressesForm,
        GetShopAddressesView $getShopAddressesView
    ): JsonResponse
    {
        return $getShopAddressesForm->makeResponse($request, $getShopAddressesView);
    }

    // address_id
    #[Route("/{address_id}", name: 'get_shop_address', methods: ['GET'])]
    public function get(
        Request            $request,
        GetShopAddressForm $getShopAddressForm,
        GetShopAddressView $getShopAddressView
    ): JsonResponse
    {
        return $getShopAddressForm->makeResponse($request, $getShopAddressView);
    }

    #[Route("/", name: 'new_shop_address', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function post(
        Request            $request,
        NewShopAddressForm $newShopAddressForm,
        NewShopAddressView $newShopAddressView
    ): JsonResponse
    {
        return $newShopAddressForm->makeResponse($request, $newShopAddressView);
    }

    // shop id
    #[Route("/{shop_id}/{address_id}", name: 'delete_shop_address', methods: ['DELETE'])]
    public function delete(
        Request               $request,
        DeleteShopAddressForm $deleteShopAddressForm,
        DeleteShopAddressView $deleteShopAddressView
    ): JsonResponse
    {
        return $deleteShopAddressForm->makeResponse($request, $deleteShopAddressView);
    }
}