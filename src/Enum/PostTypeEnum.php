<?php

namespace App\Enum;

enum PostTypeEnum: string
{
    case EVENT = 'event';
    case NEWS = 'new';
    case TOURNAMENT = 'tournament';

    public function getTranslationKey(): string
    {
        return sprintf('enum.post.%s', strtolower($this->name));
    }
}
