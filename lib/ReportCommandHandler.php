<?php

namespace PhpBench\Tabular\Cli;

use Webmozart\Console\Api\Args\Args;
use Webmozart\Console\Api\IO\IO;
use Webmozart\Console\Api\Command\Command;
use PhpBench\Tabular\Tabular;
use Webmozart\Console\UI\Component\Table;
use Webmozart\Console\UI\Style\TableStyle;

class ReportCommandHandler
{
    public function handle(Args $args, IO $io, Command $command)
    {
        $tabular = Tabular::getInstance();

        $dom = new \DOMDocument('1.0');
        $dom->load($args->getArgument('xml'));

        $tableDom = $tabular->tabulate($dom, $args->getArgument('definition'));

        if ($args->getOption('debug')) {
            $io->writeLine($tableDom->saveXml());
        }

        $rows = $tableDom->toArray();

        $table = new Table(TableStyle::solidBorder());
        $table->setHeaderRow(array_keys(reset($rows) ?: array()));

        foreach ($rows as $row) {
            $table->addRow($row);
        }

        $table->render($io);
    }
}
