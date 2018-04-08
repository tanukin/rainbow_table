#!/usr/bin/env php
<?php

use Rainbow\Services\RainbowGeneratorService;

require_once __DIR__ . "/../bootstrap/autoload.php";

$rainbowGeneratorService = new RainbowGeneratorService($generator, $redisRepository);
$rainbowGeneratorService->generate();