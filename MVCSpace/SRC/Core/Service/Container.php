<?php

declare(strict_types=1);

namespace MVCSpace\Core\Service;

use MVCSpace\Core\Exceptions\DuplicateServiceException;
use MVCSpace\Core\Exceptions\ServiceNotFoundException;
use MVCSpace\Core\Interface\IContainer;

class Container implements IContainer
{
    /**
     * @var Container|null $instance Holds the instance of the class. Used for singleton.
     */
    private static ?Container $instance = null;
    /**
     * @var array $services Stores the 'services' registered.
     */
    private array $services = [];

    /**
     * Prevents instantiation as an object. Used for singleton.
     */
    private function __construct()
    {
    }

    /**
     * Provides the single instance of the class.
     * @return IContainer
     */
    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Registers a service based on the key and the function that is constructing the given service.
     * @param string $key
     * @param callable $construct
     * @return void
     * @throws DuplicateServiceException
     */
    public function set(string $key, callable $construct): void
    {
        if (array_key_exists($key, $this->services)) {
            throw new DuplicateServiceException($key);
        }

        $this->services[$key] = $construct;
    }

    /**
     * Returns a service based on the provided key.
     *
     * If it's the first usage of that given service, it'll be built first.
     *
     * This provides caching of that service, because it'll only be built once.
     * @param string $key
     * @return object
     * @throws ServiceNotFoundException
     */
    public function get(string $key): object
    {
        if (!array_key_exists($key, $this->services)) {
            throw new ServiceNotFoundException($key);
        }

        if (is_callable($this->services[$key])) {
            $this->services[$key] = ($this->services[$key])();
        }

        return $this->services[$key];
    }
}