<?php

namespace App\Controller\Api;

use App\Form\Payment\VerifyPaymentForm;
use App\Lib\Controller\BaseController;
use App\View\Payment\VerifyPaymentView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payments')]
#[Tag(name: 'Payment', description: 'Payment operations')]
class PaymentController extends BaseController
{
    #[Route('/verify', name: 'verify_payment', methods: ['GET'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function verify(
        Request           $request,
        VerifyPaymentForm $verifyPaymentForm,
        VerifyPaymentView $verifyPaymentView
    ): JsonResponse
    {
        return $verifyPaymentForm->makeResponse($request, $verifyPaymentView);
    }
}
