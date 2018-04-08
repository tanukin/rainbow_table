<?php

use Rainbow\Controllers\RainbowController;
use Rainbow\Core\Request;
use Rainbow\Core\Response;
use Rainbow\Services\RainbowService;

require_once __DIR__ . "/../bootstrap/autoload.php";

$service = new RainbowService($generator, $redisRepository);
$controller = new RainbowController($service);
$request = new Request();
$response = new Response();
$controller->getKey($request, $response);