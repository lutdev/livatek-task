<?php

declare(strict_types=1);

namespace App;

use DI\Container;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;

class Kernel
{
    /**
     * @param array<string, string[]> $routes
     *
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(array $routes): string
    {
        if (\count($routes) === 0) {
            //It should be 404, but I need more time
            throw new NotFoundException('No routes defined in the system');
        }

        $url = $_SERVER['REQUEST_URI'];

        $diContainer = $this->getDIContainer();
        $controllerName = null;
        $actionName = null;

        foreach ($routes as $path => $actions) {
            $path = str_replace('/', '\/', $path);

            if (preg_match('/^'.$path.'$/', $url) === 1) {
                [$controllerName, $actionName] = $actions;

                break;
            }
        }

        if ($controllerName === null || $actionName === null) {
            throw new NotFoundException('No routes defined in the system');
        }

        return $diContainer->get($controllerName)->{$actionName}();
    }

    /**
     * @throws Exception
     */
    private function getDIContainer(): Container
    {
        $builder = new ContainerBuilder();
        $defPath = dirname(__DIR__) . '/config/di.php';
        $builder->addDefinitions($defPath);

        return $builder->build();
    }
}