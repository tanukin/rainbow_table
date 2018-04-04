#! /usr/bin/env php
<?php



$i = 0;
while($i < $chainLength) {
    $positions = array();
    $positions[] = mt_rand(0, $hashLastByte);
    for($j = 1; $j < 4; ++$j) {
        do {
            $ind = mt_rand(0, $hashLastByte);
            if(!in_array($ind, $positions)) {
                $positions[] = $ind;
                break;
            }
        }
        while(true);
    }
    if(!in_array($positions, $reductions)) {  // все редукции различны
        $reductions[] = $positions;
        ++$i;
    }
}



Class Rainbow
{
    private $reductions = [];
    /**
     * @var array
     */
    private $alphabet;
    /**
     * @var int
     */
    private $chainLength;
    /**
     * @var int
     */
    private $hashLastByte;
    /**
     * @var int
     */
    private $wordLength;

    public function __construct(array $alphabet, int $wordLength, int $chainLength, int $hashLastByte)
    {
        $this->alphabet = $alphabet;
        $this->chainLength = $chainLength;
        $this->hashLastByte = $hashLastByte;
        $this->wordLength = $wordLength;

        mt_srand($chainLength);

    }

    public function getCountAlphabet(array $alphabet): int
    {
        return count($alphabet) - 1;
    }

    public function getWord()
    {
        $word = '';
        for($i = 0; $i < $this->wordLength; $i++)
            $word .= $this->alphabet[mt_rand(0, $this->getCountAlphabet($this->alphabet))];

        return $word;
    }

    public function reduction($hash, $step) {
        global $reductions;
        $pos = $reductions[$step % $this->chainLength];

        mt_srand(ord($hash[$pos[0]]) | ord($hash[$pos[1]]) << 8 | ord($hash[$pos[2]]) << 16 | ord($hash[$pos[3]]) << 24);
        return $this->getWord();
    }

    public function getEndOfChain($word, $startStep = 0) {
        for($i = $startStep; $i < $this->chainLength; ++$i) {
            $hash = md5($word, true);
            $word = $this->reduction($hash, $i);
        }
        return $word;
    }

    public function getWordsInChain($hash) {
        $words = array(); // массив последних слов в цепочке для длины 100, 99, 98 и тд
        for($i = 0, $n = $this->chainLength; $i < $n; ++$i) {
            $wordStart = $this->reduction($hash, $i);
            $wordEnd = $this->getEndOfChain($wordStart, $i + 1);
            $words[] = $wordEnd;
        }
        return $words;
    }
}

$alphabet = array_merge(range(0,9));
//$alphabet = array_merge(range(0,9), range('A', 'Z'), range('a','z'));
$chainLength = 1000; // длина цепочки из хэшей и редукций
$hashLastByte = 15; // номер последнего байта хэша, начиная с 0 (для MD5 – 15)


$rainbow = new Rainbow($alphabet, 2, $chainLength, $hashLastByte);

echo $rainbow->getWordsInChain("8e296a067a37563370ded05f5a3bf3ec");