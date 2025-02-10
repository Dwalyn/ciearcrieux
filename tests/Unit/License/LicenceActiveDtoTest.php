<?php

namespace App\Tests\Unit\License;

use App\Dto\License\LicenceActiveDto;
use App\Enum\LicenseTypeEnum;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LicenceActiveDtoTest extends KernelTestCase
{
    public function testDTO(): void
    {
        $licenceActiveDto = new LicenceActiveDto(
            startDate: (new \DateTime()),
            endDate: (new \DateTime()),
            type: LicenseTypeEnum::ADULT,
            price: 100,
        );
        $licenceActiveDto->addDetail('test');

        self::assertEquals((new \DateTime())->format('Y'), $licenceActiveDto->startYear);
        self::assertEquals((new \DateTime())->format('Y'), $licenceActiveDto->endYear);
        self::assertEquals(LicenseTypeEnum::ADULT, $licenceActiveDto->type);
        self::assertEquals(100, $licenceActiveDto->price);
        self::assertEquals(['test'], $licenceActiveDto->getDetails());
    }
}
