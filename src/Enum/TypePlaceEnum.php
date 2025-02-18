<?php

namespace App\Enum;

enum TypePlaceEnum: string
{
    case INDOOR = 'indoor';
    case OUTDOOR = 'outdoor';

    public function getTranslationKey(): string
    {
        return sprintf('enum.trainingPlace.%s', strtolower($this->name));
    }
}
