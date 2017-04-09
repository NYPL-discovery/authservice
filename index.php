<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\SwaggerGenerator;
use NYPL\Starter\Config;

Config::initialize(__DIR__ . '/config');

$service = new Service();

$service->get("/api/v0.1/auth/swagger", function (Request $request, Response $response) {
    return SwaggerGenerator::generate(
        [__DIR__ . "/src"],
        $response
    );
});

$service->get("/api/v0.1/auth/patron/tokens/{id}", function (Request $request, Response $response, $parameters) {
    $controller = new Controller\AuthController($request, $response, 600);
    return $controller->getToken($parameters["id"]);
});

//$service->get("/api/v0.1/auth/patron/logins", function (Request $request, Response $response) {
//    $controller = new Controller\AuthController($request, $response, 600);
//    return $controller->getLogin();
//});

$service->run();
