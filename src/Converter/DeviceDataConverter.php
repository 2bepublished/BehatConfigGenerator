<?php

namespace Pub\BehatConfigGenerator\Converter;

use Plum\Plum\Converter\ConverterInterface;
use Pub\BehatConfigGenerator\Device;
use Pub\BehatConfigGenerator\DeviceFactory;

class DeviceDataConverter implements ConverterInterface
{
    protected $devicesByName = [];
    protected $deviceFactory;

    /**
     * @param Device[] $devices
     */
    public function __construct(array $devices, DeviceFactory $factory)
    {
        $this->deviceFactory = $factory;

        foreach ($devices as $device) {
            $this->devicesByName[$device->getName()] = $device;
        }
    }

    public function convert($item)
    {
        if (!isset($this->devicesByName[$item['name']])) {
            return;
        }

        $device = $this->devicesByName[$item['name']];
        $this->deviceFactory->update($device, $item);

        return $device;
    }
}
