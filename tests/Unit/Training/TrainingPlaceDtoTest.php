<?php

namespace App\Tests\Unit\Training;

use App\Dto\Training\AdressDto;
use App\Dto\Training\DayDto;
use App\Dto\Training\TrainingPlaceDto;
use App\Enum\TypePlaceEnum;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TrainingPlaceDtoTest extends KernelTestCase
{
    public function testDTO(): void
    {
        $trainingPlateDto = new TrainingPlaceDto(
            id: 1,
            name: 'Training place test',
            typePlaceEnum: TypePlaceEnum::OUTDOOR,
            adressDto: $this->createMock(AdressDto::class),
            startDate: new \DateTime(),
            endDate: new \DateTime(),
        );
        $trainingPlateDto->addDayDto($this->createMock(DayDto::class));

        self::assertEquals(1, $trainingPlateDto->id);
        self::assertEquals('Training place test', $trainingPlateDto->name);
        self::assertEquals(TypePlaceEnum::OUTDOOR, $trainingPlateDto->typePlaceEnum);
        self::assertEquals(1, $trainingPlateDto->getListDayDto()->count());
        self::assertEquals(
            sprintf('%s - %s', (new \DateTime())->format('d/m/Y'), (new \DateTime())->format('d/m/Y')),
            $trainingPlateDto->getPeriodDate()
        );
    }
}
