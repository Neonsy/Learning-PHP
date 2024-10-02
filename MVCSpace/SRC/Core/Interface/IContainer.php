<?php

declare(strict_types=1);

namespace MVCSpace\Core\Interface;

interface IContainer
{
    public static function getInstance(): self;
}