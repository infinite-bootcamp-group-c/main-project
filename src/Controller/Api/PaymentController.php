<?php

namespace App\Controller\Api;

use App\Lib\Controller\BaseController;
use App\Lib\Service\Payment\PaymentGatewayFactory;
use Exception;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payments')]
#[Tag(name: 'Payment', description: 'Payment operations')]
class PaymentController extends BaseController
{
    /**
     * @throws Exception
     */
    #[Route('/request', name: 'request_payment', methods: ['GET'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function request(
        Request               $request,
        PaymentGatewayFactory $paymentGatewayFactory,
    ): JsonResponse
    {
        $payment = $paymentGatewayFactory->get('zarinpal')->request(
            amount: 5000, // TODO:: we should get this from the database
            params: [
                'user_id' => 1,
            ],
            callbackUrl: $this->getParameter('zarinpal')['callback_url'],
        );

        if ($payment['result'] == 'warning')
            throw new BadRequestHttpException($payment['error']);

        return $this->json([
            'redirect_url' => $payment['url'],
        ]);

    }

    /**
     * @throws Exception
     */
    #[Route('/verify', name: 'verify_payment', methods: ['GET'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function verify(
        Request               $request,
        PaymentGatewayFactory $paymentGatewayFactory,
    ): JsonResponse
    {
        $verify = $paymentGatewayFactory->get('zarinpal')->verify(
            amount: 5000, // TODO:: we should get this from the database
            authority: $request->get('Authority'),
        );

        if ($verify['result'] == 'success') {
            return $this->json([
                'result' => 'success',
                ...$verify,
            ]);
        } else {
            return $this->json([
                'result' => 'error',
                ...$verify,
            ]);
        }
    }

}
