<?php

namespace App\Lib\Service\Payment;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class APaymentGateway implements IPaymentGateway
{

    public function __construct(
        public ContainerBagInterface $params,
        public HttpClientInterface   $httpClient
    )
    {
    }

    public function config(?string $name = null)
    {
        $configName = $this->getConfigName();
        try {
            if ($name)
                return $this->params->get($configName)[$name];
            return $this->params->get($configName);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            throw new BadRequestHttpException("$$configName config not found");
        }
    }

}
