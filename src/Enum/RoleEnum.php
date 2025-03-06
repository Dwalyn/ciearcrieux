<?php

namespace App\Enum;

enum RoleEnum: string
{
    case ROLE_ADMIN = 'Administrateur';
    case ROLE_USER = 'membre';
}
