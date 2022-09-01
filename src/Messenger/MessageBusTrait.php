<?php

namespace App\Messenger;

use Symfony\Component\Messenger\MessageBusInterface;

trait MessageBusTrait
{
    private ?MessageBusInterface $messageBus = null;

    public function setMessageBus(MessageBusInterface $bus): void
    {
        $this->messageBus = $bus;
    }

    public function dispatch(object $message): void
    {
        $this->messageBus->dispatch($message);
    }
}