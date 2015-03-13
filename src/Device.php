<?php

namespace Pub\BehatConfigGenerator;

class Device
{
    protected $modules;

    protected $name;

    protected $minkSession;

    public function __construct($name, array $modules)
    {
        $this->name = $name;
        $this->modules = $modules;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function setMinkSession(MinkSession $session)
    {
        $this->minkSession = $session;
    }

    public function getMinkSession()
    {
        return $this->minkSession;
    }

    public function setModules(array $modules)
    {
        $this->modules = $modules;
    }
}
