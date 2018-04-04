<?php

namespace Rainbow\Interfaces;

interface RepositoryInterface
{
    /**
     * Set key value
     *
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function set(string $key, string $value): bool;

    /**
     * Take the value of the key
     *
     * @param string $key
     *
     * @return string|null
     */
    public function get(string $key): ?string;
}