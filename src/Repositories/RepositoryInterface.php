<?php

namespace Rainbow\Repositories;

interface RepositoryInterface
{
    public function get(string $key): ?string;

    public function set(string $key, string $hash);

    public function hasKeyByHash(string $key): bool;

}