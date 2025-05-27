<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandInterface;
use App\Form\Datas\LicensePeriod\Price\EditPriceFormData;

class UpdateRentPriceCommand implements CommandInterface
{
    public function __construct(
        public readonly EditPriceFormData $data,
    ) {
    }
}
