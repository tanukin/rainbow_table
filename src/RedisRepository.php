<?php

namespace Rainbow;

use Predis\Client;
use Rainbow\Interfaces\RepositoryInterface;

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
     * @var resource
     */
    private $connect;

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
     * {@inheritdoc}
     */
    public function set(string $key, string $value): bool
    {
        $this->getConnect()->set($key, $value);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key): ?string
    {
        return $this->getConnect()->get($key);
    }

    protected function getConnect()
    {
        if (!isset($this->connect)) {
            $this->connect = new Client(sprintf("%s://%s:%d", $this->scheme, $this->host, $this->port));
        }

        return $this->connect;
    }
}