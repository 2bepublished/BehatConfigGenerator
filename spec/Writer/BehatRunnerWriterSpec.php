<?php

namespace spec\Pub\BehatConfigGenerator\Writer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Pub\BehatConfigGenerator\Device;
use Pub\BehatConfigGenerator\Module;
use Symfony\Component\Filesystem\Filesystem;

class BehatRunnerWriterSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem, '/tmp/my-runner', '/tmp/behat.yml');
    }

    function it_is_a_writer()
    {
        $this->shouldHaveType('Plum\Plum\Writer\WriterInterface');
    }

    function it_writes_a_device_config_into_the_output(Filesystem $filesystem)
    {

        $module1 = new Module('my-module', ['path/to/features'], ['My\Context']);
        $device = new Device('my-device', [$module1]);
        $this->prepare();
        $this->writeItem($device);
        $this->finish();
        $runnerContent = <<<RUNNER
#!/bin/bash
vendor/bin/behat -c /tmp/behat.yml -p my-device

RUNNER;
        $filesystem->dumpFile('/tmp/my-runner', $runnerContent)->shouldBeCalled();
    }
}
