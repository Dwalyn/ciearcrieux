<?php

namespace App\Enum;

enum LicenseTypeEnum: string
{
    case ADULT = 'adult';
    case DISCOVER = 'discover';

    case MINOR = 'minor';

    public function getTranslationKey(): string
    {
        return sprintf('enum.license.%s', strtolower($this->name));
    }
}
