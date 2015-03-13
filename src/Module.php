<?php

namespace Pub\BehatConfigGenerator;

class Module
{
    protected $paths;
    protected $contexts;
    protected $name;

    public function __construct($name, array $paths, array $contexts)
    {
        $this->name = $name;
        $this->paths = $paths;
        $this->contexts = $contexts;
    }

    public function getPaths()
    {
        return $this->paths;
    }

    public function getContexts()
    {
        return $this->contexts;
    }

    public function getName()
    {
        return $this->name;
    }
}
