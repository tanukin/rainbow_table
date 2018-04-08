<?php

namespace Rainbow\Config;

use Rainbow\Exceptions\EmptyContentException;
use Symfony\Component\Yaml\Yaml;

class ConfigFile
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }


    /**
     * @return string
     *
     * @throws EmptyContentException
     */
    public function getScheme(): string
    {
        return $this->getOptions()['redis']['scheme'];
    }

    /**
     * @return string
     *
     * @throws EmptyContentException
     */
    public function getHost(): string
    {
        return $this->getOptions()['redis']['host'];
    }

    /**
     * @return int
     *
     * @throws EmptyContentException
     */
    public function getPort(): int
    {
        return $this->getOptions()['redis']['port'];
    }

    /**
     * @return array
     *
     * @throws EmptyContentException
     */
    public function getAlphabet(): array
    {
        $generator = $this->getOptions()['generator'];
        $arr = [];

        if ($generator['numeric'])
            $arr = array_merge($arr, range(0, 9));
        if ($generator['capitalLetters'])
            $arr = array_merge($arr, range('A', 'Z'));
        if ($generator['smallLetters'])
            $arr = array_merge($arr, range('a', 'z'));

        if (empty($arr))
            throw new EmptyContentException("Configuration (generator) invalid ");

        return $arr;
    }

    /**
     * @return int
     *
     * @throws EmptyContentException
     */
    public function getPasswordLength(): int
    {
        return $this->getOptions()['passwordLength'];
    }

    /**
     * @return mixed
     *
     * @throws EmptyContentException
     */
    protected function getOptions()
    {
        if (!file_exists($this->path))
            throw new EmptyContentException("File not found");

        $content = Yaml::parseFile($this->path);

        if (empty($content))
            throw new EmptyContentException("Config file is empty");

        return $content;
    }
}