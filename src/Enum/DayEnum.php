<?php

namespace App\Enum;

enum DayEnum: int
{
    case DAY_0 = 0;
    case DAY_1 = 1;
    case DAY_2 = 2;
    case DAY_3 = 3;
    case DAY_4 = 4;
    case DAY_5 = 5;
    case DAY_6 = 6;

    public function getTranslationKey(): string
    {
        return sprintf('enum.day.%s', strtolower($this->name));
    }
}
