<?php

namespace PhpBench\Tabular\Cli;

use Webmozart\Console\Config\DefaultApplicationConfig;
use Webmozart\Console\Api\Args\Format\Argument;
use Webmozart\Console\Api\Args\Format\Option;

class TabularApplicationConfig extends DefaultApplicationConfig
{
    protected function configure()
    {
        parent::configure();

        $this->setName('tabular');
        $this->setVersion('0.1');
        $this->beginCommand('report')
            ->setDescription('Generate a console report from an XML file and a tabular configuration file.')
            ->setHandler(new ReportCommandHandler())
            ->addArgument('xml', Argument::REQUIRED, 'XML file to process')
            ->addArgument('definition', Argument::REQUIRED, 'Tabular definition to use')
            ->addOption('debug', null, Option::NO_VALUE, 'Show debug output');
    }
}
