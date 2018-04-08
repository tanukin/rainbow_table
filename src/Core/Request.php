<?php

namespace Rainbow\Core;

use Rainbow\Exceptions\MethodIsForbiddenHttpException;

class Request
{
    /**
     * @param string $key
     *
     * @return string
     *
     * @throws MethodIsForbiddenHttpException
     */
    public function get(string $key): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && array_key_exists($key, $_POST))
            return $_POST[$key];

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && array_key_exists($key, $_GET))
            return $_GET[$key];

        throw new MethodIsForbiddenHttpException('Use the POST or the GET method');
    }
}