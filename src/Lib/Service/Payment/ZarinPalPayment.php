<?php

namespace App\Lib\Service\Payment;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ZarinPalPayment implements IPaymentGateway
{
    public function __construct(
        private readonly HttpClientInterface   $httpClient,
        private readonly ContainerBagInterface $params,
    )
    {
    }

    public function config($name = null)
    {
        try {
            if ($name)
                return $this->params->get('zarinpal')[$name];
            return $this->params->get('zarinpal');
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            throw new BadRequestHttpException('ZarinPal config not found');
        }
    }

    public function request($amount, array $params = [], $callbackUrl = '', $description = ''): array
    {
        $this->validateArguments($callbackUrl, $description, '', true);

        $requestType = $this->config('testing') ? 'sandbox' : 'www';

        $queryStrings = http_build_query($params, '', '&');

        $data = [
            'MerchantID' => $this->config('merchant_id'),
            'Amount' => $amount,
            'CallbackURL' => sprintf('%s?%s',
                $callbackUrl ?: $this->config('callback-url'), $queryStrings),
            'Description' => $description ?: $this->config('description')
        ];

        $url = sprintf('https://%s.zarinpal.com/pg/rest/WebGate/PaymentRequest.json', $requestType);
        $content = $this->doRequest($data, $url);

        if (is_null($content['error'])) {
            $authority = ltrim($content['Authority']);

            return [
                'result' => 'success',
                'code' => $content['Status'],
                'url' => sprintf('https://%s.zarinpal.com/pg/StartPay/%s', $requestType, $authority),
            ];
        }
        return [
            'result' => 'warning',
            'code' => $content['Status'],
            'error' => $content['error']
        ];

    }

    public function verify($amount, $authority = ''): array
    {
        $this->validateArguments(null, null, $authority);

        $requestType = $this->config('testing') ? 'sandbox' : 'www';

        $data = [
            'MerchantID' => $this->config('merchant_id'),
            'Amount' => $amount,
            'Authority' => ltrim($authority)
        ];

        $url = sprintf('https://%s.zarinpal.com/pg/rest/WebGate/PaymentVerification.json', $requestType);
        $content = $this->doRequest($data, $url);
        if (is_null($content['error'])) {
            return [
                'result' => 'success',
                'code' => $content['Status'],
                'refId' => ltrim($content['RefID'])
            ];

        }
        return [
            'result' => 'warning',
            'code' => $content['Status'],
            'error' => $content['error']
        ];
    }

    private function doRequest($data, $url): array
    {
        $jsonParams = json_encode($data);

        try {
            $response = $this->httpClient->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen($jsonParams),
                    'User-Agent' => 'ZarinPal Rest Api v1',
                ],
                'body' => $jsonParams,
            ]);

            $content = $response->toArray();
            $content['error'] = $this->getErrorMessage($content['Status']);

            if ($response->getStatusCode() !== 200)
                $content['error'] = 'تراکنش با خطا مواجه شد';

            return $content;
        } catch (TransportExceptionInterface|ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            throw new BadRequestHttpException('ZarinPal request failed');
        }
    }

    private function validateArguments($callbackUrl = '', $description = '', $authority = '', $isRequest = false): void
    {
        $errors = [];
        if (empty($this->config('merchant_id')))
            $errors[] = 'The merchant id field is required.';

        if ($isRequest) {
            if (empty($callbackUrl))
                $errors[] = 'The callback url field is required.';

            if (empty($description) && empty($this->config('description')))
                $errors[] = 'The description field is required.';
        }

        if (!$isRequest && empty($authority))
            $errors[] = 'The authority field is required.';


        if (!empty($errors))
            throw new BadRequestHttpException(implode(' ', $errors));
    }

    private function getErrorMessage(string|int $id): ?string
    {
        $id = (int)$id;
        return match ($id) {
            -1 => 'اطلاعات ارسال شده ناقص است.',
            -2 => 'آی پی یا مرچنت کد پذیرنده صحیح نیست.',
            -3 => 'با توجه به محدودیت های شاپرک امکان پرداخت با رقم درخواست شده میسر نمی باشد.',
            -4 => 'سطح تایید پذیرنده پایین تر از صطح نقره ای است.',
            -11 => 'درخواست مورد نظر یافت نشد.',
            -12 => 'امکان ویرایش درخواست میسر نمی باشد.',
            -21 => 'هیچ نوع عملیات مالی برای این تراکنش یافت نشد.',
            -22 => 'تراکنش نا موفق می باشد.',
            -33 => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد.',
            -34 => 'سقف تقسیم تراکنش از لحاظ تعداد با رقم عبور نموده است.',
            -40 => 'اجازه دسترسی به متد مربوطه وجود ندارد.',
            -41 => 'اطلاعات ارسال شده مربوط به AdditionalData غیر معتر می باشد.',
            -42 => 'مدت زمان معتبر طول عمر شناسه پرداخت بین ۳۰ دقیقه تا ۴۰ روز می باشد.',
            -54 => 'درخواست مورد نظر آرشیو شده است.',
            default => null,
        };
    }
}