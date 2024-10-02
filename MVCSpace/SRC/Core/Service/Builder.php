<?php

declare(strict_types=1);

namespace MVCSpace\Core\Service;

use MVCSpace\Core\Enum\Path;
use MVCSpace\Core\Exceptions\DuplicateServiceException;
use MVCSpace\Core\Service\Services\Database;
use MVCSpace\Core\Service\Services\SessionManager;

class Builder
{
    /**
     * @var Container $container Holding the container, so we don't have to recall the instance for each service we build.
     */
    private static Container $container;

    /**
     * Builds all the services.
     * @return void
     * @throws DuplicateServiceException
     */
    public static function build(): void
    {
        self::$container = Container::getInstance();

        self::db();
        self::sm();
    }

    /**
     * Gets the required data for the DB service and builds it up.
     * @return void
     * @throws DuplicateServiceException
     */
    private static function db(): void
    {
        // Extract env info
        $env = parse_ini_file(realpath(Path::ENV->value) . '/DB.ENV');

        $dsnInfo = [
            'host' => $env['HOST'],
            'port' => $env['PORT'],
            'dbname' => $env['DATABASE'],
            'charset' => $env['CHARSET'],
        ];

        // MYSQL:host=localhost;port=3306;dbname=dbname;charset=charset;
        $dsn = "$env[DRIVER]:" . http_build_query($dsnInfo, arg_separator: ';');

        self::$container->set('db', function () use ($dsn, $env) {
            return new Database($dsn, $env['USERNAME'], $env['PASSWORD']);
        });
    }

    /**
     * Sets the container function to make the sessionManager available.
     * @return void
     * @throws DuplicateServiceException
     */
    private static function sm(): void
    {
        self::$container->set('sm', function () {
            return new SessionManager();
        });
    }
}