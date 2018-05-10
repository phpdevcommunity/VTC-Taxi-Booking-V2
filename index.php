<?php

use App\Kernel;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;

require __DIR__ . '/vendor/autoload.php';

if (in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], true)) {
    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
//    error_reporting(E_ALL);
//    ini_set("display_errors", 1);
}


$request = ServerRequest::fromGlobals();

/**
 * @var Response $response
 */
$kernel = new Kernel();
$kernel->boot();

if (php_sapi_name() !== 'cli') {
    $response = $kernel->load($request);
    \Http\Response\send($response);
}
