<?php

namespace Rainbow\Core;

class Generator
{
    /**
     * @var array
     */
    private $alphabet;

    /**
     * @var int
     */
    private $passwordLength;

    /**
     * @var array
     */
    private $reductions = [];

    const CHAN_LENGTH = 1000;
    const HASH_LAST_BYTE = 15;

    /**
     * Generator constructor.
     *
     * @param array $alphabet
     * @param int $passwordLength
     */
    public function __construct(array $alphabet, int $passwordLength)
    {
        $this->alphabet = $alphabet;
        $this->passwordLength = $passwordLength;
    }

    public function init(): void
    {
        mt_srand(self::CHAN_LENGTH);
        $i = 0;

        while ($i < self::CHAN_LENGTH) {
            $positions = [];
            $positions[] = mt_rand(0, self::HASH_LAST_BYTE);
            for ($j = 1; $j < 4; ++$j) {
                do {
                    $ind = mt_rand(0, self::HASH_LAST_BYTE);
                    if (!in_array($ind, $positions)) {
                        $positions[] = $ind;
                        break;
                    }
                } while (true);
            }
            if (!in_array($positions, $this->reductions)) {
                $this->reductions[] = $positions;
                ++$i;
            }
        }
    }

    /**
     * @return string
     */
    public function getRandomPassword(): string
    {
        $word = '';
        $lastSymbol = count($this->alphabet) - 1;

        for ($i = 0; $i < $this->passwordLength; $i++)
            $word .= $this->alphabet[mt_rand(0, $lastSymbol)];

        return $word;
    }

    /**
     * @param string $password
     * @param int $startStep
     * @param int $length
     *
     * @return string
     */
    public function getEndOfChain(string $password, int $startStep = 0, int $length = self::CHAN_LENGTH): string
    {
        for ($i = $startStep; $i < $length; ++$i) {
            $hash = md5($password, true);
            $password = $this->reduction($hash, $i);
        }

        return $password;
    }

    /**
     * @param string $hash
     *
     * @return array
     */
    public function getPasswordInChain(string $hash): array
    {
        $passwords = [];
        for ($i = 0, $n = Generator::CHAN_LENGTH; $i < $n; ++$i) {
            $passwordStart = $this->reduction($hash, $i);
            $passwordEnd = $this->getEndOfChain($passwordStart, $i + 1);
            $passwords[] = $passwordEnd;
        }

        return $passwords;
    }

    /**
     * @param string $hash
     * @param int $step
     *
     * @return string
     */
    protected function reduction(string $hash, int $step): string
    {
        $pos = $this->reductions[$step % self::CHAN_LENGTH];

        mt_srand(
            ord($hash[$pos[0]]) |
            ord($hash[$pos[1]]) << 8 |
            ord($hash[$pos[2]]) << 16 |
            ord($hash[$pos[3]]) << 24
        );

        return $this->getRandomPassword();
    }
}