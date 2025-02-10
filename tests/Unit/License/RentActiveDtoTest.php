<?php

namespace App\Tests\Unit\License;

use App\Dto\License\RentActiveDto;
use App\Enum\RentTypeEnum;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RentActiveDtoTest extends KernelTestCase
{
    public function testDTO(): void
    {
        $rentActiveDto = new RentActiveDto(
            type: RentTypeEnum::OTHER,
            price: 100,
        );

        self::assertEquals(RentTypeEnum::OTHER, $rentActiveDto->type);
        self::assertEquals(100, $rentActiveDto->price);
    }
}
