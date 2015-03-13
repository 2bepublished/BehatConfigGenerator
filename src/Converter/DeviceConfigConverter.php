<?php

namespace Pub\BehatConfigGenerator\Converter;

use Plum\Plum\Converter\ConverterInterface;
use Pub\BehatConfigGenerator\DeviceFactory;

class DeviceConfigConverter implements  ConverterInterface
{
    protected $deviceFactory;

    public function __construct(DeviceFactory $deviceFactory)
    {
        $this->factory = $deviceFactory;
    }

    public function convert($item)
    {
        $normalizedData = [
            'name'   => $item[0],
            'config' => [
                'mink_name'                => $item[1],
                'browserstack_device' => $item[2],
                'browserstack_username' => $item[3],
                'browserstack_password' => $item[4],
                'browserstack_os' => $item[5],
                'browserstack_browser' => $item[6],
                'browserstack_version' => $item[7],
            ]
        ];

        return $this->factory->create($normalizedData);
    }
}
