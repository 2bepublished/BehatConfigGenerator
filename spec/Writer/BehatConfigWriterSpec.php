<?php

namespace spec\Pub\BehatConfigGenerator\Writer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Pub\BehatConfigGenerator\Device;
use Pub\BehatConfigGenerator\Module;

class BehatConfigWriterSpec extends ObjectBehavior
{
    function let(\Twig_Environment $twig)
    {
        $this->beConstructedWith($twig);
    }

    function it_is_a_writer()
    {
        $this->shouldHaveType('Plum\Plum\Writer\WriterInterface');
    }

    function it_writes_a_device_config_into_the_output(\Twig_Environment $twig)
    {
        $this->beConstructedWith($twig);

        $module1 = new Module('my-module', ['path/to/features'], ['My\Context']);
        $device = new Device('my-device', [$module1]);


        // expect the right twig call
        $twig->render('device.yml.twig', ['device' => $device])
            ->shouldBeCalled()
            ->willReturn('my-rendered-yml')
        ;

        $this->writeItem($device);

        $this->getOutput()->shouldBe('my-rendered-yml');
    }
}
