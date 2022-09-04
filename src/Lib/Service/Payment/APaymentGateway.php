<?php

namespace App\Lib\Service\Payment;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\Service\Attribute\Required;

abstract class APaymentGateway implements IPaymentGateway
{
    #[Required]
    public ContainerBagInterface $params;

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