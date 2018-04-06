<?php

namespace Rainbow\Repositories;

use Predis\Client;

class RedisRepository
{

    /**
     * @var string
     */
    private $scheme;
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;

    /**
     * @var Client
     */
    private $client;

    /**
     * RedisRepository constructor.
     *
     * @param string $scheme
     * @param string $host
     * @param int $port
     */
    public function __construct(string $scheme, string $host, int $port)
    {
        $this->scheme = $scheme;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return Client
     */
    public function getConnect():Client
    {
        if(!isset($this->client))
            $this->client = new Client(sprintf("%s://%s:%s", $this->scheme, $this->host, $this->port));

        return $this->client;
    }

    /**
     * @param string $hash
     *
     * @return null|string
     */
    public function get(string $hash): ?string
    {
        return $this->getConnect()->get($hash);
    }

    /**
     * @param string $key
     * @param string $hash
     */
    public function set(string $key, string $hash)
    {
        $this->getConnect()->set($hash, $key);
    }

    /**
     * @param string $hash
     *
     * @return bool
     */
    public function hasKeyByHash(string $hash): bool
    {
        return $this->getConnect()->exists($hash);
    }

}