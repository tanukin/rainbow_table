<?php

namespace Rainbow\Core;

class Response
{
    /**
     * @var int
     */
    private $codeStatus;

    const OK = 200;
    const BAD_REQUEST = 400;

    /**
     * @param int $code
     *
     * @return Response
     */
    public function setHttpStatusCode(int $code): Response
    {
        $this->codeStatus = $code;

        return $this;
    }

    /**
     * @param string $message
     */
    public function send(string $message): void
    {
        http_response_code($this->codeStatus);
        echo $message;
        exit(0);
    }
}