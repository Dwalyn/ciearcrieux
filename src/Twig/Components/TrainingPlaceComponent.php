<?php

namespace App\Twig\Components;

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
    ) {
    }

    public function getTrainingPlaceDto(): TrainingPlaceDto
    {
        return $this->query->handle(new TrainingActiveDtoQuery($this->typePlaceEnum));
    }
}
