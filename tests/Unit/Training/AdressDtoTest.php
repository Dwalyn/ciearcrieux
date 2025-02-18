<?php

namespace App\Tests\Unit\Training;

use App\Dto\Training\AdressDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdressDtoTest extends KernelTestCase
{
    public function testDTO(): void
    {
        $adressDto = new AdressDto(
            city: 'Rieux',
            cityNumber: '60940',
            adress: '15 Rue de la Vanne',
            googleMapUrl: 'url test',
        );

        self::assertEquals('Rieux', $adressDto->city);
        self::assertEquals('60940', $adressDto->cityNumber);
        self::assertEquals('15 Rue de la Vanne', $adressDto->adress);
        self::assertEquals('url test', $adressDto->googleMapUrl);
    }
}
