#! /usr/bin/env php
<?php

use Rainbow\Config\ConfigFile;
use Rainbow\RedisRepository;

require_once __DIR__."/../vendor/autoload.php";

$config = new ConfigFile(__DIR__ . "/../src/Config/configFile.yaml");

$redisRepository = new RedisRepository()

var_dump($config->getOptions());
