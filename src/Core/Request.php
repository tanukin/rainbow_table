<?php

namespace Rainbow\Core;

use Rainbow\Exceptions\InvalidArgumentHttpException;
use Rainbow\Exceptions\MethodIsForbiddenHttpException;

class Request
{
    /**
     * @param string $key
     *
     * @return string
     *
     * @throws InvalidArgumentHttpException
     * @throws MethodIsForbiddenHttpException
     */
    public function get(string $key): string
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
            throw new MethodIsForbiddenHttpException('Only use the POST method');

        if (!array_key_exists($key, $_POST))
            throw new InvalidArgumentHttpException(sprintf('%s argument not passed', $key));

        return $_POST[$key];
    }
}