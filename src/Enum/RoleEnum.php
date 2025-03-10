<?php

namespace App\Enum;

enum RoleEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_USER = 'ROLE_USER';

    public function getTranslationKey(): string
    {
        return sprintf('enum.role.%s', $this->name);
    }
}
