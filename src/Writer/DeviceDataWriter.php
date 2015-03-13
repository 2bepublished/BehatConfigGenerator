<?php

namespace Pub\BehatConfigGenerator\Writer;

use Plum\Plum\WorkflowConcatenator;
use Plum\Plum\Writer\WriterInterface;

class DeviceDataWriter implements WriterInterface
{
    protected $devices;
    protected $name;
    protected $concat;

    public function __construct($name, array $devices = [])
    {
        $this->name = $name;
        $this->devices = $devices;
    }

    /**
     * Write the given item.
     *
     * @param mixed $item
     *
     * @return void
     */
    public function writeItem($item)
    {
        $featureName = $item['feature'];
        unset($item['feature']);

        foreach ($item as $device => $active) {
            if (!$active) {
                return;
            }

            if (!isset($this->devices[$device])) {
                $this->devices[$device] = [
                    'name' => $device,
                    'modules' => []
                ];
            }

            if (!isset($this->devices[$device]['modules'][$this->name])) {
                $this->initModuleConfig($device);
            }

            $this->devices[$device]['modules'][$this->name]['paths'][] = $featureName;
        }
    }

    /**
     * Prepare the writer.
     *
     * @return void
     */
    public function prepare()
    {
        // TODO: Implement prepare() method.
    }

    /**
     * Finish the writer.
     *
     * @return void
     */
    public function finish()
    {

    }

    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param $device
     *
     * @return array
     */
    protected function initModuleConfig($device)
    {
        return $this->devices[$device]['modules'][$this->name] = [
            'name'     => $this->name,
            'paths'    => [],
            'contexts' => []
        ];
    }
}
