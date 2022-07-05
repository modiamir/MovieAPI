<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ValidationFailedExceptionHandlerSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$event->getThrowable() instanceof ValidationFailedException) {
            return;
        }

        /** @var ValidationFailedException $validationFailedException */
        $validationFailedException = $event->getThrowable();

        $response = new JsonResponse([
            'errors' => $this->getJoinedMessages($validationFailedException->getViolations()),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
        $event->setResponse($response);
        $event->stopPropagation();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }

    public function getJoinedMessages(ConstraintViolationListInterface $violationList): array
    {
        $messages = [];
        foreach ($violationList as $violation) {
            $messages[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $messages;
    }
}
