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
        $tabular = new Tabular();

        $dom = new \DOMDocument('1.0');
        $dom->load($args->getArgument('xml'));

        $tableDom = $tabular->tabulate($dom, $args->getArgument('definition'));

        if ($args->getOption('debug')) {
            $io->writeLine($tableDom->saveXml());
        }

        $rows = array();
        foreach ($tableDom->xpath()->query('//row') as $rowEl) {
            $row = array();
            foreach ($tableDom->xpath()->query('.//cell', $rowEl) as $cellEl) {
                $colName = $cellEl->getAttribute('name');

                // exclude cells
                if (isset($config['exclude']) && in_array($colName, $config['exclude'])) {
                    continue;
                }

                $row[$colName] = $cellEl->nodeValue;
            }

            $rows[] = $row;
        }

        $table = new Table(TableStyle::solidBorder());
        $table->setHeaderRow(array_keys($row ?: array()));

        foreach ($rows as $row) {
            $table->addRow($row);
        }

        $table->render($io);
    }
}
