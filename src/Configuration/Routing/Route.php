<?php

declare(strict_types=1);

namespace App\Configuration\Routing;

/**
 * Base class for handling routes
 */
class Route
{
    /** @var array<string, string[]> */
    private array $routesGetMethod = [];

    /** @var array<string, string[]> */
    private array $routesPostMethod = [];

    /** @var array<string, string[]> */
    private array $routesDeleteMethod = [];

    public function get(string $path, string $controllerName, string $action): void
    {
        $this->routesGetMethod[$path] = [$controllerName, $action];
    }

    public function post(string $path, string $controllerName, string $action): void
    {
        $this->routesPostMethod[$path] = [$controllerName, $action];
    }

    public function delete(string $path, string $controllerName, string $action): void
    {
        $this->routesDeleteMethod[$path] = [$controllerName, $action];
    }

    /**
     * @return array<string, string[]>
     */
    public function getRoutesForGetMethod(): array
    {
        return $this->routesGetMethod;
    }

    /**
     * @return array<string, string[]>
     */
    public function getRoutesForPostMethod(): array
    {
        return $this->routesPostMethod;
    }

    /**
     * @return array<string, string[]>
     */
    public function getRoutesForDeleteMethod(): array
    {
        return $this->routesDeleteMethod;
    }
}