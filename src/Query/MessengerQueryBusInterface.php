<?php

namespace App\Query;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBusInterface implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function handle(QueryInterface $query): mixed
    {
        return $this->handleQuery($query);
    }
}
