<?php

namespace spec\Pub\BehatConfigGenerator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeviceSpec extends ObjectBehavior
{
    function it_can_be_created_with_a_name_and_modules()
    {
        $this->beConstructedWith('my-name', ['my-module']);

        $this->getName()->shouldBe('my-name');
        $this->getModules()->shouldBe(['my-module']);
    }
}
