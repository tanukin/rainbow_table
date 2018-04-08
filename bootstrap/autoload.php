<?php

use Rainbow\Config\ConfigFile;
use Rainbow\Core\Generator;
use Rainbow\Exceptions\EmptyContentException;
use Rainbow\Repositories\RedisRepository;

require __DIR__ . "/../vendor/autoload.php";

$config = new ConfigFile(__DIR__ . "/../src/Config/configFile.yaml");

try {
    $redisRepository = new RedisRepository($config->getScheme(), $config->getHost(), $config->getPort());

    $generator = new Generator($config->getAlphabet(), $config->getPasswordLength());
    $generator->init();

} catch (EmptyContentException $e) {
    echo $e->getMessage();
    exit;
}