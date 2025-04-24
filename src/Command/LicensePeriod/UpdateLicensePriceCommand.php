<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandInterface;
use App\Form\Datas\LicensePeriod\EditPriceFormData;

class UpdateLicensePriceCommand implements CommandInterface
{
    public function __construct(
        public readonly EditPriceFormData $data,
    ) {
    }
}
