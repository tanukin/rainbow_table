<?php

use Rainbow\Config\ConfigFile;
use Rainbow\Controllers\RainbowController;
use Rainbow\Core\Request;
use Rainbow\Core\Response;
use Rainbow\Exceptions\EmptyContentException;
use Rainbow\Repositories\RedisRepository;
use Rainbow\Services\RainbowService;

require_once __DIR__."/../vendor/autoload.php";

$config = new ConfigFile(__DIR__ . "/../src/Config/configFile.yaml");

try {
    $redisRepository = new RedisRepository($config->getScheme(), $config->getHost(), $config->getPort());

    // для теста положим в redis
    $redisRepository->set("123", "202cb962ac59075b964b07152d234b70");

    $service = new RainbowService($redisRepository);
    $controller = new RainbowController($service);
    $request = new Request();
    $response = new Response();
    $controller->getKey($request, $response);

} catch (EmptyContentException $e) {
    $response->setHttpStatusCode(Response::BAD_REQUEST)->send($e->getMessage());
}
