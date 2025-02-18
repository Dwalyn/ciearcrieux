<?php

namespace App\Dto\Training;

class AdressDto
{
    public function __construct(
        public readonly string $city,
        public readonly string $cityNumber,
        public readonly string $adress,
        public readonly string $googleMapUrl,
    ) {
    }
}
