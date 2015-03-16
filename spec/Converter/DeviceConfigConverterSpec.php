<?php

namespace spec\Pub\BehatConfigGenerator\Converter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Pub\BehatConfigGenerator\Device;
use Pub\BehatConfigGenerator\DeviceFactory;
use Pub\BehatConfigGenerator\MinkSession;

class DeviceConfigConverterSpec extends ObjectBehavior
{
    function it_is_a_converter()
    {
        $this->beConstructedWith(new DeviceFactory());
        $this->shouldHaveType('Plum\Plum\Converter\ConverterInterface');
    }

    function it_converts_a_item()
    {
        $this->beConstructedWith(new DeviceFactory());
        $input = [
            "firefox","firefox_35_win","ANY","my-username","my-password","WINDOWS","firefox","35"
        ];

        $expectedDevice = new Device('firefox', []);
        $expectedDevice->setMinkSession(
            new MinkSession(
                'firefox_35_win', [
                'mink_name'             => 'firefox_35_win',
                'browserstack_device'   => 'ANY',
                'browserstack_username' => 'my-username',
                'browserstack_password' => 'my-password',
                'browserstack_os'       => 'WINDOWS',
                'browserstack_browser'  => 'firefox',
                'browserstack_version'  => '35',
            ]
            )
        );

        $this->convert($input)->shouldBeLike($expectedDevice);
    }

    function it_converts_a_item_with_no_version()
    {
        $this->beConstructedWith(new DeviceFactory());
        $input = [
            "firefox","firefox_35_win","ANY","my-username","my-password","WINDOWS","firefox"
        ];

        $expectedDevice = new Device('firefox', []);
        $expectedDevice->setMinkSession(
            new MinkSession(
                'firefox_35_win', [
                'mink_name'             => 'firefox_35_win',
                'browserstack_device'   => 'ANY',
                'browserstack_username' => 'my-username',
                'browserstack_password' => 'my-password',
                'browserstack_os'       => 'WINDOWS',
                'browserstack_browser'  => 'firefox',
                'browserstack_version'  => '',
            ]
            )
        );

        $this->convert($input)->shouldBeLike($expectedDevice);
    }
}
