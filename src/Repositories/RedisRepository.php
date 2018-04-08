<?php

namespace Rainbow\Repositories;

use Predis\Client;

class RedisRepository implements RepositoryInterface
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
    protected function getConnect(): Client
    {
        if (!isset($this->client)) {
            $this->client = new Client(sprintf("%s://%s:%s", $this->scheme, $this->host, $this->port));
            $this->client->select(0);
        }

        return $this->client;
    }

    /**
     * @param string $key
     *
     * @return null|string
     */
    public function get(string $key): ?string
    {
        return $this->getConnect()->get($key);
    }

    /**
     * @param string $key
     * @param string $hash
     */
    public function set(string $key, string $hash)
    {
        $this->getConnect()->set($key, $hash);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasKeyByHash(string $key): bool
    {
        return $this->getConnect()->exists($key);
    }

}