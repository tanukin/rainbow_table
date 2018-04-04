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
    public function getPost(): int
    {
        return $this->getOptions()['redis']['post'];
    }
      

    /**
     * @return mixed
     *
     * @throws EmptyContentException
     */
    public function getOptions()
    {
        $this->isExistFile();

        $content = Yaml::parseFile($this->path);

        if (empty($content))
            throw new EmptyContentException("Config file is empty");

        return $content;
    }





    /**
     * @throws EmptyContentException
     */
    protected function isExistFile(): void
    {
        if (!file_exists($this->path))
            throw new EmptyContentException("File not found");
    }

}