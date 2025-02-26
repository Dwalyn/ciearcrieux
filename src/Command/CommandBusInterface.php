<?php

namespace App\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): mixed;
}
