<?php

namespace App\Enum;

enum TrainingPeriodEnum: string
{
    case SUMMER = 'summer';
    case WINTER = 'winter';

    public function getTranslationKey(): string
    {
        return sprintf('enum.trainingPeriod.%s', strtolower($this->name));
    }
}
