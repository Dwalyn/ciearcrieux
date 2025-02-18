<?php

namespace App\Tests\Unit\Training;

use App\Dto\Training\DayDto;
use App\Enum\DayEnum;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DayDtoTest extends KernelTestCase
{
    public function testDTO(): void
    {
        $dayDto = new DayDto(DayEnum::DAY_1);

        self::assertEquals(DayEnum::DAY_1, $dayDto->day);
    }
}
