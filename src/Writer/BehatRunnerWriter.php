<?php

namespace Pub\BehatConfigGenerator\Writer;

use Plum\Plum\Writer\WriterInterface;
use Pub\BehatConfigGenerator\Device;
use Symfony\Component\Filesystem\Filesystem;

class BehatRunnerWriter implements WriterInterface
{

    protected $filesystem;
    protected $runnerPath;
    protected $configPath;
    protected $runnerContent;

    public function __construct(Filesystem $filesystem, $runnerPath, $configPath)
    {
        $this->filesystem    = $filesystem;
        $this->runnerPath    = $runnerPath;
        $this->configPath    = $configPath;
        $this->runnerContent = '';
    }

    /**
     * @param Device $item
     */
    public function writeItem($item)
    {
        $this->runnerContent .= sprintf("vendor/bin/behat -c %s -p %s\n", $this->configPath, $item->getName());
    }

    /**
     * Prepare the writer.
     *
     * @return void
     */
    public function prepare()
    {
        $this->runnerContent = "#!/bin/bash\n";
    }

    /**
     * Finish the writer.
     *
     * @return void
     */
    public function finish()
    {
        $this->filesystem->dumpFile($this->runnerPath, $this->runnerContent);
    }
}
