<?php

namespace Pub\BehatConfigGenerator;

class MinkSession
{

    protected $config;

    protected $name;

    public function __construct($name, array $config)
    {
        $this->name = $name;
        $this->config = $config;
    }

    protected function get($name)
    {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
    }

    public function getUsername()
    {
        return $this->get('browserstack_username');
    }

    public function getPassword()
    {
        return $this->get('browserstack_password');
    }

    public function getDevice()
    {
        return $this->get('browserstack_device');
    }

    public function getTunnel()
    {
        return $this->get('browserstack_tunnel');
    }

    public function getDebug()
    {
        return $this->get('browserstack_debug');
    }

    public function getOs()
    {
        return $this->get('browserstack_os');
    }

    public function getBrowser()
    {
        return $this->get('browserstack_browser');
    }

    public function getVersion()
    {
        return $this->get('browserstack_version');
    }

    public function getName()
    {
        return $this->name;
    }
}
