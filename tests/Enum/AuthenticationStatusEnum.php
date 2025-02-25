<?php

namespace App\Tests\Enum;

enum AuthenticationStatusEnum: string
{
    case AUTH_OK = 'OK';
    case AUTH_NOT_OK = 'NOT_OK';
}
