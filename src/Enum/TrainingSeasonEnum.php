<?php

namespace App\Enum;

enum TrainingSeasonEnum: string
{
    case SUMMER = 'summer';
    case WINTER = 'winter';

    public function getTranslationKey(): string
    {
        return sprintf('enum.trainingSeason.%s', strtolower($this->name));
    }
}
