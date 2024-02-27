<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Kernel;

$routing = include __DIR__ . '/config/routing.php';

$kernel = new Kernel();
$requestMethod = $_SERVER['REQUEST_METHOD'];
echo $kernel->run($routing[$requestMethod]);
