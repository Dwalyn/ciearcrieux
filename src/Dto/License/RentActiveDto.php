<?php

namespace App\Dto\License;

use App\Enum\RentTypeEnum;

class RentActiveDto
{
    public function __construct(
        public readonly RentTypeEnum $type,
        public readonly int $price,
    ) {
    }
}
