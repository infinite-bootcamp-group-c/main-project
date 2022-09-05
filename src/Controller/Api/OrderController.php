<?php

namespace App\Controller\Api;

use App\Lib\Controller\BaseController;
use App\Lib\Service\Payment\Gateway\ZarinpalPayment;
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

//    #[Route('/add', name: 'add_new', methods: ['POST'])]
//    #[RequestBody(content: new JsonContent(default: '{}'))]
//    public function addToBasket(
//        Request         $request,
//        ZarinpalPayment $zarinPal,
//    ): JsonResponse
//    {
//
//    }
}