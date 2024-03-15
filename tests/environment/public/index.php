<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));
if (!str_contains(getcwd(), 'vendor')) {
    /**
     * Ausführung im Core
     */
    $appPath = realpath(getcwd() . '/../');
    $vendorPath = realpath(getcwd() . '/../../../vendor/');
} else {
    /**
     * Ausführung im Projekt
     */
    $appPath = realpath(getcwd() . '/../');
    $vendorPath = realpath(getcwd() . '/../../../../../');
}

require $vendorPath . '/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once $appPath . '/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
