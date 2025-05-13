<?php

namespace App\Twig\Components;

use App\Command\CommandBusInterface;
use App\Command\LicensePeriod\CheckLicensePeriodCommand;
use App\Dto\Training\TrainingPlaceDto;
use App\Enum\TrainingPlaceDisplayEnum;
use App\Enum\TypePlaceEnum;
use App\Query\FindUs\TrainingActiveDtoQuery;
use App\Query\QueryBusInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class TrainingPlaceComponent
{
    public TypePlaceEnum $typePlaceEnum = TypePlaceEnum::INDOOR;
    public TrainingPlaceDisplayEnum $display = TrainingPlaceDisplayEnum::INLINE;

    public function __construct(
        private readonly QueryBusInterface $query,
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function getTrainingPlaceDto(): TrainingPlaceDto
    {
        $this->commandBus->dispatch(new CheckLicensePeriodCommand());

        return $this->query->handle(new TrainingActiveDtoQuery($this->typePlaceEnum));
    }
}
