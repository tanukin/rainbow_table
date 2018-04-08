<?php

namespace Rainbow\Services;

use Rainbow\Core\Generator;
use Rainbow\Exceptions\EmptyContentException;
use Rainbow\Repositories\RepositoryInterface;

class RainbowService
{
    /**
     * @var RepositoryInterface
     */
    private $repository;
    /**
     * @var Generator
     */
    private $generator;

    /**
     * RainbowService constructor.
     *
     * @param Generator $generator
     * @param RepositoryInterface $repository
     */
    public function __construct(Generator $generator, RepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->generator = $generator;
    }

    /**
     * @param string $hash
     *
     * @return null|string
     *
     * @throws EmptyContentException
     */
    public function getKey(string $hash): ?string
    {
        $passwords = $this->generator->getPasswordInChain($hash);

        $pairs = [];
        foreach ($passwords as $password) {
            if ($this->repository->hasKeyByHash($password))
                $pairs[] = $this->repository->get($password);
        }

        $turn = false;
        $password = '';
        $countPairs = count($pairs);

        for ($i = 0; $i < $countPairs; $i++) {
            $steps = array_search($pairs[$i], $passwords);
            $password = $this->generator->getEndOfChain($pairs[$i], 0, $steps);

            if (md5($password, true) === $hash) {
                $turn = true;
                break;
            }
        }

        if (!$turn)
            throw new EmptyContentException(sprintf("Key not found for hash = %s", $hash));

        return $password;
    }
}