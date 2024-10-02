<?php

declare(strict_types=1);

namespace MVCSpace\Core\Enum\HTTP;

/**
 * Binds a supported HTTP method to an action name, which shall be used by a controller.
 */
enum MethodAction: string
{
    case GET = 'getAction';
    case POST = 'postAction';
    case PUT = 'putAction';
    case DELETE = 'deleteAction';
}
