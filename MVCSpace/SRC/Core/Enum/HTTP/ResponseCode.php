<?php

declare(strict_types=1);

namespace MVCSpace\Core\Enum\HTTP;

enum ResponseCode: int
{
    case OK = 200;
    case REDIRECT = 303;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;
}
