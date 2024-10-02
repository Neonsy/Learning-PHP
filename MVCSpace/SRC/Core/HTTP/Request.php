<?php

declare(strict_types=1);

namespace MVCSpace\Core\HTTP;

use Error;
use MVCSpace\Core\App;
use MVCSpace\Core\Enum\HTTP\MethodAction;
use MVCSpace\Core\Exceptions\InvalidContentTypeException;

class Request
{
    /**
     * @var string $path The path of the requested URI/URL.
     */
    private string $path;
    /**
     * @var MethodAction $methodAction Holds the HTTP request method, and the name of the action to be called by a controller.
     */
    private MethodAction $methodAction;
    /**
     * @var array|null $payload The body / payload sent with the request.
     */
    private ?array $payload;
    /**
     * @var array $headers The headers sent with the request.
     */
    private array $headers;

    public function __construct()
    {
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $this->methodAction = $this->verifyRequestMethod();

        $this->headers = getallheaders();

        try {
            $this->parsePayload();
        } catch (InvalidContentTypeException $e) {
            App::dump($e->getMessage(), exit: true);
        }
    }

    /**
     * Verifies if the requested HTTP method is supported by the application.
     * @return MethodAction
     */
    private function verifyRequestMethod(): MethodAction
    {
        try {
            return MethodAction::{$_SERVER['REQUEST_METHOD']};
        } catch (Error $e) {
            App::dump($e->getMessage(), exit: true);
        }
    }

    /**
     * Parses the payload if it's a GET request.
     *
     * Must have a valid Content-Type for other Methods.
     * @return void
     * @throws InvalidContentTypeException
     */
    private function parsePayload(): void
    {
        $this->payload = $this->methodAction === MethodAction::GET ? $_GET : null;

        if (is_null($this->payload)) {
            $contentType = $this->headers['Content-Type'] ?? null;

            if ($contentType === 'application/x-www-form-urlencoded') {
                parse_str(file_get_contents('php://input'), $this->payload);
            } else if ($contentType === 'application/json') {
                $this->payload = json_decode(file_get_contents('php://input'), true);
            }

            // If the payload is still null, either the contentType wasn't set or is invalid.
            if (is_null($this->payload)) {
                throw new InvalidContentTypeException($contentType);
            }
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethodAction(): MethodAction
    {
        return $this->methodAction;
    }

    public function getPayload(): ?array
    {
        return $this->payload;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}