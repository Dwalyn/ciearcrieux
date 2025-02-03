<?php

namespace App\Dto\License;

use App\Enum\RentTypeEnum;

class RentActiveDto
{
    public readonly RentTypeEnum $type;
    public readonly int $price;

    public function __construct(array $data)
    {
        $this->type = $data['type'];
        $this->price = $data['price'];
    }
}
