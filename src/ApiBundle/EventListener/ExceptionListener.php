<?php

namespace ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof BadRequestHttpException) {

            $response = new Response($exception->getMessage());
            $this->setResponse($event, $response, $exception);

        } elseif ($exception instanceof UnauthorizedHttpException) {

            $errorMessage = [
                'reason' => 'authenticationError',
                'message' => 'error.authentication',
                'description' => 'Credentials are incorrect'
            ];
            $response = new JsonResponse($errorMessage);
            $this->setResponse($event, $response, $exception);
        }
    }

    /**
     * @param GetResponseForExceptionEvent $event
     * @param Response $response
     * @param HttpException $exception
     */
    private function setResponse(
        GetResponseForExceptionEvent $event,
        Response $response,
        HttpException $exception
    ) {
        $response->setStatusCode($exception->getStatusCode());
        $response->headers->replace($exception->getHeaders());
        $event->setResponse($response);
    }
}
