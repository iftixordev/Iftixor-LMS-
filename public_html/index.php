<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto-detect cPanel structure
$basePath = dirname(__DIR__);
if (basename(__DIR__) === 'public_html') {
    $appPath = $basePath;
} else {
    $appPath = dirname(__DIR__);
}

if (file_exists($maintenance = $appPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appPath . '/vendor/autoload.php';

$app = require_once $appPath . '/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);