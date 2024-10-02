<?php

declare(strict_types=1);

namespace MVCSpace\Core\Enum;

enum ContentType: string
{
    case CSS = 'text/css';
    case JS = 'text/javascript';
    case PNG = 'image/png';
    case JPG = 'image/jpeg';
    case SVG = 'image/svg+xml';
}
