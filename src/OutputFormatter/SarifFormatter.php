<?php

namespace DepReaper\Engine\OutputFormatter;

use Symfony\Component\Console\Output\OutputInterface;

class SarifFormatter implements FormatterInterface
{
    public function __construct(private OutputInterface $output) {}

    public function format(array $result): void
    {
        $sarif = [
            'version' => '2.1.0',
            '$schema' => 'https://json.schemastore.org/sarif-2.1.0.json',
            'runs' => [[
                'tool' => ['driver' => ['name' => 'dep-reaper', 'version' => '1.0.0']],
                'results' => []
            ]],
        ];
        $this->output->writeln(json_encode($sarif, JSON_PRETTY_PRINT));
    }
}
