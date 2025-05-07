<?php

namespace App\Enum;

enum TimeStatusEnum: string
{
    case IN_PROGRESS = 'IN_PROGRESS';
    case FINISHED = 'FINISHED';

    case NOT_BEGIN = 'NOT_BEGIN';

    public function getTranslationKey(): string
    {
        return sprintf('enum.timestatus.%s', $this->name);
    }

    public static function getBadgeClass(self $value): string
    {
        return match ($value) {
            self::IN_PROGRESS => 'success',
            self::FINISHED => 'danger',
            self::NOT_BEGIN => 'secondary',
        };
    }
}
