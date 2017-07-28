<?php

namespace ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof BadRequestHttpException) {
            $response = $this->setJsonResponse($exception);
            $event->setResponse($response);
        }
    }

    /**
     * @param HttpException $exception
     *
     * @return Response
     */
    public function setJsonResponse(HttpException $exception)
    {
        $response = new Response($exception->getMessage());

        $response->setStatusCode($exception->getStatusCode());
        $response->headers->replace($exception->getHeaders());

        return $response;

    }
}
