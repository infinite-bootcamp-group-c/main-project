<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface) {

            $response = new JsonResponse([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());

        } else {

            $response = new JsonResponse([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'traces' => $exception->getTrace()
            ]);
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);
    }
}