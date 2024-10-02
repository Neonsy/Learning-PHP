<?php

declare(strict_types=1);

namespace MVCSpace\Core\Enum;

enum Path: string
{
    case ROOT = __DIR__ . '/../../../';
    case PUBLIC = self::ROOT->value . '/Public';
    case SRC = self::ROOT->value . '/SRC';
    case CONTROLLER = self::SRC->value . '/Controller';
    case VIEW = self::SRC->value . '/View';
    case ENV = self::SRC->value . '/Core/ENV';
}
