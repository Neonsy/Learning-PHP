<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$middlewares = []; // Array for global middlewares

$middlewares[] = new \MVCSpace\Core\Middleware\Global\StaticFiles(); // Adding static files middleware

$app = new \MVCSpace\Core\App($middlewares); // Creating app

$app->run();