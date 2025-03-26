<?php

namespace App\Enum;

enum TimeStatusEnum: string
{
    case IN_PROGRESS = 'En cours';
    case FINISHED = 'Terminée';

    public function getTranslationKey(): string
    {
        return sprintf('enum.timestatus.%s', $this->name);
    }

    public static function getBadgeClass(self $value): string
    {
        return match ($value) {
            self::IN_PROGRESS => 'success',
            self::FINISHED => 'danger',
        };
    }
}
