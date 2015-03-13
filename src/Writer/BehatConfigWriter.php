<?php

namespace Pub\BehatConfigGenerator\Writer;

use Plum\Plum\Writer\WriterInterface;
use Twig_Environment;

class BehatConfigWriter implements WriterInterface
{
    protected $twig;

    protected $config;

    protected $output;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
        $this->output = '';
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
        $this->output .= $this->twig->render('device.yml.twig', ['device' => $item]);
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

    public function getOutput()
    {
        return $this->output;
    }
}
