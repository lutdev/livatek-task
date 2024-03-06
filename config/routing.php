<?php

declare(strict_types=1);

use App\Configuration\Routing\Route;
use App\Controller\HomeController;
use App\Controller\TaskController;

$route = new Route();
/** @uses HomeController::index */
$route->get('/', HomeController::class, 'index');

/** @uses TaskController::createNewTask() */
$route->post('/create', TaskController::class, 'createNewTask');

/** @uses TaskController::showTasks() */
$route->get('/tasks', TaskController::class, 'showTasks');

/** @uses TaskController::deleteTask() */
$route->delete('/task', TaskController::class, 'deleteTask');

return [
    'GET' => $route->getRoutesForGetMethod(),
    'POST' => $route->getRoutesForPostMethod(),
    'DELETE' => $route->getRoutesForDeleteMethod(),
];