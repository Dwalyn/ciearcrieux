<?php

namespace App\Enum;

enum RentTypeEnum: string
{
    case FIRST = 'first_year';
    case OTHER = 'other';

    public function getTranslationKey(): string
    {
        return sprintf('enum.rent.%s', strtolower($this->name));
    }
}
