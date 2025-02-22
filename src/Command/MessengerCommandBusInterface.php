<?php

namespace App\Command;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBusInterface implements CommandBusInterface
{
    use HandleTrait {
        handle as handleCommand;
    }

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function dispatch(CommandInterface $command): mixed
    {
        return $this->handleCommand($command);
    }
}
