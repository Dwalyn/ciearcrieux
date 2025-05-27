<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;

class EditTrainingCommandHandler implements CommandHandlerInterface
{
    public function __construct()
    {
    }

    public function __invoke(EditTrainingCommand $command)
    {
        dump($command->formData);
        exit;
    }
}
