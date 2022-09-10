<?php

namespace App\Controller\Api;

use App\Form\Order\ConfirmOrderForm;
use App\Form\Order\ConfirmWithNewAddressForm;
use App\Form\Order\DeleteOrderForm;
use App\Form\Order\GetOrdersForm;
use App\Form\Order\NewAddressForm;
use App\Form\Order\PayOrderForm;
use App\Form\Order\SelectAddressForm;
use App\Lib\Controller\BaseController;
use App\View\Order\ConfirmOrderView;
use App\View\Order\DeleteOrderView;
use App\View\Order\GetOrdersView;
use App\View\Order\PayOrderView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders')]
#[Tag(name: 'Order', description: 'Order operations')]
class OrderController extends BaseController
{
    #[Route("/new-address", name: "Add New Shipment Address", methods: ["POST"])]
    #[RequestBody(content: new JsonContent("{}"))]
    public function new_address(
        Request $request,
        NewAddressForm $newAddressForm,
    ): JsonResponse
    {
        return $newAddressForm->makeResponse($request);
    }

    #[Route("/select-address/{order_id}/{address_id}", name: "Select Shipment Address", methods: ["POST"])]
    #[RequestBody(content: new JsonContent("{}"))]
    public function select_address(
        Request $request,
        SelectAddressForm $selectAddressForm,
    ): JsonResponse
    {
        return $selectAddressForm->makeResponse($request);
    }

    #[Route("/confirm/{order_id}", name: "Select Shipment Address", methods: ["POST"])]
    #[RequestBody(content: new JsonContent("{}"))]
    public function confirm(
        Request $request,
        ConfirmOrderForm $confirmOrderForm,
        ConfirmOrderView $confirmOrderView
    ): JsonResponse
    {
        return $confirmOrderForm->makeResponse($request, $confirmOrderView);
    }

    #[Route("/pay/{order_id}", name: "Pay", methods: ["POST"])]
    #[RequestBody(content: new JsonContent("{}"))]
    public function pay(
        Request $request,
        PayOrderForm $payOrderForm,
        PayOrderView $payOrderView,
    ): JsonResponse
    {
        return $payOrderForm->makeResponse($request, $payOrderView);
    }

    #[Route("/delete/{id}", name: "Delete Order", methods: ["DELETE"])]
    public function delete(
        Request $request,
        DeleteOrderForm $deleteOrderForm,
        DeleteOrderView $deleteOrderView
    ): JsonResponse
    {
        return $deleteOrderForm->makeResponse($request, $deleteOrderView);
    }

    #[Route("/get", name: "Get Orders", methods: ["GET"])]
    public function get(
        Request $request,
        GetOrdersForm $getOrderForm,
        GetOrdersView $getOrderView
    ): JsonResponse
    {
        return $getOrderForm->makeResponse($request, $getOrderView);
    }
}