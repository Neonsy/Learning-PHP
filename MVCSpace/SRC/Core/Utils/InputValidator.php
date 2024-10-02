<?php

declare(strict_types=1);

namespace MVCSpace\Core\Utils;

class InputValidator
{
    public static function invalidUsername(string $username): bool
    {
        return !ctype_alpha($username) || strlen($username) < 3 || strlen($username) > 18;
    }

    public static function invalidEmail(string $email): bool|int
    {
        return !preg_match('/^[a-z]+[a-z0-9]*@[a-z]+[a-z0-9]*\.[a-z]{2,}$/i', $email) ||
            strlen($email) > 32;
    }

    public static function invalidPassword(string $password): bool
    {
        return !ctype_alnum($password) || strlen($password) < 8;
    }

    public static function invalidNote(string $title, string $content): bool{
        return strlen($title) < 1 || strlen($title) > 64 || strlen($content) < 1;
    }
}