<?php

namespace spec\Pub\BehatConfigGenerator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Pub\BehatConfigGenerator\Device;

class DeviceFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Pub\BehatConfigGenerator\DeviceFactory');
    }

    function it_creates_devices_and_modules_based_on_array_data()
    {
        $data = [
            'name' => 'my-device',
            'modules' => [
                [
                    'name' => 'my-module',
                    'paths' => ['my-paths'],
                    'contexts' => ['my-contexts']
                ]
            ]
        ];

        $this->create($data)->shouldHaveType('Pub\BehatConfigGenerator\Device');
    }
}
