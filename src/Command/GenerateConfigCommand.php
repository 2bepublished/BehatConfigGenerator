<?php
namespace Pub\BehatConfigGenerator\Command;

use Plum\Plum\Converter\HeaderConverter;
use Plum\Plum\Filter\SkipFirstFilter;
use Plum\Plum\Reader\ArrayReader;
use Pub\BehatConfigGenerator\Writer\BehatRunnerWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Plum\Plum\Filter\CallbackFilter;
use Plum\Plum\Workflow;
use Plum\Plum\Writer\ArrayWriter;
use Plum\PlumCsv\CsvReader;
use Pub\BehatConfigGenerator\Converter\DeviceConfigConverter;
use Pub\BehatConfigGenerator\Converter\DeviceDataConverter;
use Pub\BehatConfigGenerator\DeviceFactory;
use Pub\BehatConfigGenerator\Writer\BehatConfigWriter;
use Pub\BehatConfigGenerator\Writer\DeviceDataWriter;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Twig_Environment;
use Twig_Loader_Filesystem;

class GenerateConfigCommand extends Command
{
    protected $output;
    /**
     * @var InputInterface
     */
    protected $input;

    protected function configure()
    {
        $this
            ->setName('pub:generate-behat-config')
            ->setDescription('Generate a behat.yml for multiple device configs and mink/browserstack.')
            ->addArgument('device-config', InputArgument::REQUIRED, 'CSV of all devices used by browserstack')
            ->addArgument('feature-configs', InputArgument::REQUIRED, 'Path where feature config csvs are located.')
            ->addArgument('output-path', InputArgument::REQUIRED, 'Path where the behat.yml should be dumped.')
            ->addOption(
                'template-path',
                null,
                InputOption::VALUE_REQUIRED,
                'path to twig templates',
                __DIR__.'/../../templates/'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input  = $input;

        // create device objects with mink config
        // data/devices.csv -> Device[]
        $devices = $this->parseDeviceConfigurations($input);

        // Create module config for Devices
        // data/feature_list/*.csv -> Device::Modules[]
        $moduleData = $this->parseFeatureFiles($input);

        $twig = $this->getTwigEnvironment();

        // Merge Modules + Devices
        // write out config into .yml
        $this->generateConfig($twig, $devices, $moduleData, $input->getArgument('output-path'));

    }

    protected function info($string)
    {
        if (OutputInterface::VERBOSITY_VERBOSE <= $this->output->getVerbosity()) {
            $this->output->writeln('<info>'.$string.'</info>');
        }
    }

    /**
     * @return array
     */
    protected function getTwigEnvironment()
    {
        $loader = new Twig_Loader_Filesystem($this->input->getOption('template-path'));

        return new Twig_Environment($loader);
    }

    /**
     * @param InputInterface $input
     *
     * @return array
     */
    protected function parseDeviceConfigurations(InputInterface $input)
    {
        $deviceConfigPath = $input->getArgument('device-config');
        $arrayWriter      = new ArrayWriter();
        $workflow         = new Workflow();
        $workflow->addConverter(new DeviceConfigConverter(new DeviceFactory()));
        $workflow->addWriter($arrayWriter);
        $result = $workflow->process(new CsvReader($deviceConfigPath));

        $this->info(sprintf('Found: %s devices.', $result->getReadCount()));

        return $arrayWriter->getData();
    }

    /**
     * @param InputInterface $input
     *
     * @return array
     */
    protected function parseFeatureFiles(InputInterface $input)
    {
        $finder       = new Finder();
        $featureFiles = $finder->files()->name('*.csv')->in($input->getArgument('feature-configs'));

        $moduleData = [];
        foreach ($featureFiles as $file) {

            $name = $file->getBaseName('.features.csv');
            $this->info('Module: '.$name);

            $csvReader = new CsvReader($file);
            $workflow  = new Workflow();
            $writer    = new DeviceDataWriter($name, $moduleData);

            $workflow->addConverter(new HeaderConverter());
            $workflow->addFilter(new SkipFirstFilter(1));

            $workflow->addWriter($writer);
            $result     = $workflow->process($csvReader);
            $moduleData = $writer->getDevices();
            $this->info(sprintf('Mapped: %s features on devices.', $result->getReadCount()));
        }

        return $moduleData;
    }

    /**
     * @param $twig
     * @param $devices
     * @param $moduleData
     *
     * @return BehatConfigWriter
     */
    protected function generateConfig($twig, $devices, $moduleData, $outputDir)
    {
        $configPath = $this->input->getArgument('output-path').'/behat.yml';
        $runnerPath = $this->input->getArgument('output-path').'/behat-runner.sh';

        $configWriter = new BehatConfigWriter($twig);
        $workflow     = new Workflow();
        $workflow->addConverter(new DeviceDataConverter($devices, new DeviceFactory()));
        $workflow->addFilter(
            new CallbackFilter(
                function ($item) {
                    if ($item === null) {
                        return false;
                    }

                    return true;
                }
            )
        );

        $runnerWriter = new BehatRunnerWriter(new Filesystem(), $runnerPath, $configPath);

        $workflow->addWriter($configWriter);
        $workflow->addWriter($runnerWriter);
        $workflow->process(new ArrayReader($moduleData));

        // write out config
        $filesystem = new Filesystem();
        $filesystem->dumpFile($configPath, $configWriter->getOutput());
    }
}
