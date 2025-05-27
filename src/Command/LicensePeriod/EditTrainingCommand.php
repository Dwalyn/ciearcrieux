<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandInterface;
use App\Form\Datas\LicensePeriod\Training\EditTrainingFormData;

class EditTrainingCommand implements CommandInterface
{
    public function __construct(
        public readonly EditTrainingFormData $formData
    ) {
    }
}
