<?php

namespace App\Enum;

enum LicensedTypeEnum: string
{
    case BEGINNER = 'beginner';
    case CONFIRMED = 'confirmed';

    public function getTranslationKey(): string
    {
        return sprintf('enum.licensedType.%s', strtolower($this->name));
    }
}
