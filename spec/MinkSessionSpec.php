<?php

namespace spec\Pub\BehatConfigGenerator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MinkSessionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('my-name', []);
        $this->shouldHaveType('Pub\BehatConfigGenerator\MinkSession');
    }

    function it_can_be_created_with_config_data()
    {
        $this->beConstructedWith('my-name', [
            'browserstack_username' => 'user',
            'browserstack_password' => 'password',
            'browserstack_device' => 'iphone',
            'browserstack_tunnel' => true,
            'browserstack_debug' => true,
        ]);

        $this->getName()->shouldBe('my-name');
        $this->getUsername()->shouldBe('user');
        $this->getPassword()->shouldBe('password');
        $this->getDevice()->shouldBe('iphone');
        $this->getTunnel()->shouldBe(true);
        $this->getDebug()->shouldBe(true);
    }
}
