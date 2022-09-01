<?php

namespace App\Listener;

use App\ResponseBuilder\ErrorBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function __construct(private ErrorBuilder $errorBuilder) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        if ($event->getThrowable() instanceof NotFoundHttpException) {
            $event->setResponse(new JsonResponse($this->errorBuilder->__invoke('Entity not found.'), Response::HTTP_NOT_FOUND));
        }
    }
}