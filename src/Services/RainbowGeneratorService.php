<?php

namespace Rainbow\Services;

use Rainbow\Core\Generator;
use Rainbow\Repositories\RepositoryInterface;

class RainbowGeneratorService
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
     * @var int
     */
    private $amountGenerateCouple;

    /**
     * RainbowGeneratorService constructor.
     *
     * @param Generator $generator
     * @param RepositoryInterface $repository
     * @param int $amountGenerateCouple
     */
    public function __construct(Generator $generator, RepositoryInterface $repository, int $amountGenerateCouple = 100000)
    {
        $this->repository = $repository;
        $this->generator = $generator;
        $this->amountGenerateCouple = $amountGenerateCouple;
    }

    public function generate(): void
    {
        $i = 0;
        while ($i < $this->amountGenerateCouple) {
            $password = $this->generator->getRandomPassword();

            if (!$this->repository->hasKeyByHash($password)) {
                $this->repository->set($password, $this->generator->getEndOfChain($password));
                $i++;
            }
        }
    }
}