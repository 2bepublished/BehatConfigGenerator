<?php

namespace spec\Pub\BehatConfigGenerator\Converter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Pub\BehatConfigGenerator\Device;
use Pub\BehatConfigGenerator\DeviceFactory;
use Pub\BehatConfigGenerator\Module;

class DeviceDataConverterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([], new DeviceFactory());
    }

    function it_is_a_converter()
    {
        $this->shouldHaveType('Plum\Plum\Converter\ConverterInterface');
    }

    function it_updates_devices_with_their_modules(Device $device)
    {
        $this->beConstructedWith([$device], new DeviceFactory());

        $input = [
            'name'    => 'firefox',
            'modules' => [
                [
                    'name' => 'my-module',
                    'paths' => [
                        'show',
                        'search',
                    ],
                    'contexts' => []
                ]
            ]
        ];

        $module = new Module('my-module', ['show', 'search'], []);
        $device->getName()->willReturn('firefox');
        $device->setModules([$module])->shouldBeCalled();
        $this->convert($input);
    }
}
