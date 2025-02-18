<?php

namespace App\Tests\Unit\Training;

use App\Dto\Training\HourPeriodDto;
use App\Enum\LicensedTypeEnum;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HourPeriodDtoTest extends KernelTestCase
{
    public function testDTO(): void
    {
        $hourPeriodDto = new HourPeriodDto(
            (new \DateTime())->setTime('06', '00'),
            (new \DateTime())->setTime('18', '45'),
            LicensedTypeEnum::CONFIRMED,
        );

        self::assertEquals(sprintf('%s - %s', '06:00', '18:45'), $hourPeriodDto->getTimePeriod());
        self::assertEquals(LicensedTypeEnum::CONFIRMED, $hourPeriodDto->licensedTypeEnum);
    }
}
