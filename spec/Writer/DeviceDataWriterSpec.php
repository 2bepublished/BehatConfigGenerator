<?php

namespace spec\Pub\BehatConfigGenerator\Writer;

use PhpSpec\ObjectBehavior;
use Plum\Plum\WorkflowConcatenator;
use Prophecy\Argument;

class DeviceDataWriterSpec extends ObjectBehavior
{
    function it_is_a_writer()
    {
        $this->beConstructedWith('my-module');
        $this->shouldHaveType('Plum\Plum\Writer\WriterInterface');
    }

    function it_writers_device_data()
    {
        $this->beConstructedWith('my-module');
        $inputs = [
            [
                'feature' => 'show',
                'firefox' => true,
                'iphone'  => true
            ],
            [
                'feature' => 'search',
                'firefox' => true,
                'iphone'  => false
            ]
        ];

        foreach ($inputs as $input) {
            $this->writeItem($input);
        }
        $this->getDevices()->shouldReturn(
            [
                'firefox' =>
                [
                    'name'    => 'firefox',
                    'modules' => [
                        'my-module' =>  [
                            'name' => 'my-module',
                            'paths' => [
                                'show',
                                'search',
                            ],
                            'contexts' => [

                            ]
                        ]
                    ]
                ],
                'iphone' =>
                [
                    'name'    => 'iphone',
                    'modules' =>
                        [
                            'my-module' => [
                                'name' => 'my-module',
                                'paths' => [
                                    'show',
                                ],
                                'contexts' => [

                                ]
                            ]
                        ]
                ]

            ]
        );
    }
}
