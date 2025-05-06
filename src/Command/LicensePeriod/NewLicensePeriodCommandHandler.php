<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;

class NewLicensePeriodCommandHandler implements CommandHandlerInterface
{
    public function __construct()
    {
    }

    public function __invoke(NewLicensePeriodCommand $command): void
    {
        // TODO: Implement __invoke() method.
    }
}
