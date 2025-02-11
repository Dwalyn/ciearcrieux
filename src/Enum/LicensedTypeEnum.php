<?php

namespace App\Enum;

enum UserTypeEnum: string
{
    case BEGINNER = 'beginner';
    case CONFIRM = 'confirm';

    public function getTranslationKey(): string
    {
        return sprintf('enum.userType.%s', strtolower($this->name));
    }
}
