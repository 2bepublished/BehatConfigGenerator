<?php

namespace Pub\BehatConfigGenerator;

class DeviceFactory
{
    public function create(array $data)
    {
        $device = new Device($data['name'], []);
        $this->update($device, $data);

        return $device;
    }

    public function update(Device $device, $data)
    {
        if (isset($data['modules'])) {
            $modules = [];
            foreach ($data['modules'] as $module) {
                $modules[] = new Module($module['name'], $module['paths'], $module['contexts']);
            }

            $device->setModules($modules);
        }


        if (isset($data['config'])) {
            $minkSession = new MinkSession($data['config']['mink_name'], $data['config']);
            $device->setMinkSession($minkSession);
        }

        return $device;
    }
}
