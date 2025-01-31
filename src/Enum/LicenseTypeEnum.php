<?php

namespace App\Enum;

enum LicenseTypeEnum: string
{
    case ADULT = 'Adulte';
    case DISCOVER = 'Découverte';

    case MINOR = '- de 18 ans';
}
