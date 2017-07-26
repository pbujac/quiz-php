<?php

namespace ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (
            $exception instanceof BadRequestHttpException ||
            $exception instanceof UnauthorizedHttpException
        ) {
            $response = new JsonResponse([
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ]);

            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
            $event->setResponse($response);
        }
    }
}
