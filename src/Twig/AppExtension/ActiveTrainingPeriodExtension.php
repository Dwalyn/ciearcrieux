<?php

namespace App\Twig\AppExtension;

use App\Enum\TypePlaceEnum;
use App\Repository\TrainingPeriodRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ActiveTrainingPeriodExtension extends AbstractExtension
{
    public function __construct(private readonly TrainingPeriodRepository $trainingPeriodRepository)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('typePlaceActive', [$this, 'getTypePlaceActive']),
        ];
    }

    public function getTypePlaceActive(\DateTime $dateTime = new \DateTime()): TypePlaceEnum
    {
        $trainingPeriod = $this->trainingPeriodRepository->getCurrentTrainingPeriod($dateTime);
        $enum = $trainingPeriod?->getTypePlaceEnum();
        if (null !== $enum) {
            return $enum;
        }

        return TypePlaceEnum::OUTDOOR;
    }
}
