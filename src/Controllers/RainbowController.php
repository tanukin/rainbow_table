<?php

namespace Rainbow\Controllers;

use Rainbow\Core\Request;
use Rainbow\Core\Response;
use Rainbow\Exceptions\EmptyContentException;
use Rainbow\Exceptions\HttpException;
use Rainbow\Services\RainbowService;

class RainbowController
{
    private $key = 'hash';
    /**
     * @var RainbowService
     */
    private $rainbowService;

    /**
     * RainbowController constructor.
     *
     * @param RainbowService $rainbowService
     */
    public function __construct(RainbowService $rainbowService)
    {
        $this->rainbowService = $rainbowService;
    }

    public function getKey(Request $request, Response $response)
    {
        try {
            $hash = $request->get($this->key);
            $key = $this->rainbowService->getKey($hash);

        } catch (HttpException $e) {
            $response->setHttpStatusCode(Response::BAD_REQUEST)->send($e->getMessage());
        } catch (EmptyContentException $e) {
            $response->setHttpStatusCode(Response::OK)->send($e->getMessage());
        }

        $response->setHttpStatusCode(Response::OK)->send($key);
    }
}