<?php

namespace Rainbow\Services;

use Rainbow\Exceptions\EmptyContentException;
use Rainbow\Repositories\RedisRepository;

class RainbowService
{
    /**
     * @var RedisRepository
     */
    private $repository;

    /**
     * RainbowService constructor.
     *
     * @param RedisRepository $repository
     */
    public function __construct(RedisRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $hash
     *
     * @return string
     *
     * @throws EmptyContentException
     */
    public function getKey(string $hash): string
    {
        if(!$this->repository->hasKeyByHash($hash))
            throw new EmptyContentException(sprintf("Key not found for hash = %s", $hash));

        return $this->repository->get($hash);
    }

}