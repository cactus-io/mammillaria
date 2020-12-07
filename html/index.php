<?php
require __DIR__ . '/../vendor/autoload.php';

use Pluf\Di\Container;
use Pluf\Http\HttpResponseEmitter;
use Pluf\Http\ResponseFactory;
use Pluf\Http\ServerRequestFactory;
use Pluf\Scion\UnitTracker;
use Cactus\Mammillaria\JwtToMessage;
use Cactus\Mammillaria\MessageToFile;
use Pluf\Scion\Process\Http\FileToHttpResponse;

// *****************************************************************
// Services
// TODO: maso, 2020: we are in need to discover and load services the
// springBoot is a very good model.
// *****************************************************************
$container = new Container();

$container['configs'] = Container::service(function () {
    return new Options(require __DIR__ . '/configs.php');
});

$container['FileToHttpResponseUnit'] = Container::service(function () {
    return new FileToHttpResponse();
});

$container['JwtToMessageUnit'] = Container::service(function (Options $configs) {
    $options = $configs->startsWith('mammillaria_', true);
    return new JwtToMessage($options->key, $options->algorithems);
});

$container['MessageToFileUnit'] = Container::service(function (Options $configs) {
    $options = $configs->startsWith('mammillaria_', true);
    return new MessageToFile($options->storage);
});

// *****************************************************************
// Processes
// *****************************************************************
$unitTracker = new UnitTracker(require __DIR__ . '/units.php', $container);
$responseFactory = new ResponseFactory();
$httpResponseEmitter = new HttpResponseEmitter();
$httpResponseEmitter->emit($unitTracker->doProcess([
    'request' => ServerRequestFactory::createFromGlobals(),
    'response' => $responseFactory->createResponse(200, 'Success'),
    'responseFactory' => $responseFactory
]));

