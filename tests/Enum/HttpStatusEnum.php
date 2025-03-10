<?php

namespace App\Tests\Enum;

enum HttpStatusEnum: int
{
    case OK = 200;
    case FORBIDDEN = 403;
    case REDIRECT = 302;
}
