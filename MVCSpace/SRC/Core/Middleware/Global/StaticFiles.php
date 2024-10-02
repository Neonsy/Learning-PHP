<?php

declare(strict_types=1);

namespace MVCSpace\Core\Middleware\Global;

use MVCSpace\Core\Enum\ContentType;
use MVCSpace\Core\Enum\HTTP\ResponseCode;
use MVCSpace\Core\Enum\Path;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\IMiddleware;

class StaticFiles implements IMiddleware
{

    public function __invoke(Request $request, Response $response, callable $next): void
    {
        foreach (ContentType::cases() as $contentType) {
            if (str_contains(strtolower($request->getPath()), '.' . strtolower($contentType->name))) {
                $path = realpath(Path::PUBLIC->value) . $request->getPath();

                if (file_exists($path)) {
                    $response->addHeader('Content-Type', $contentType->value)
                        ->responseCode(ResponseCode::OK)
                        ->specifyContent(file_get_contents($path))
                        ->send();
                } else {
                    $response->responseCode(ResponseCode::NOT_FOUND)
                        ->specifyContent($request->getPath() . ' not found.')
                        ->send();
                }
            }
        }

        $next($request, $response);
    }
}