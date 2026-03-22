<?php

namespace DepReaper\Engine\OutputFormatter;

use DepReaper\Engine\Dependency\DependencyCollection;
use DepReaper\Engine\Dependency\DependencyInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GitlabFormatter implements FormatterInterface
{
    public function __construct(private OutputInterface $output) {}

    public function format(array $result): void
    {
        /** @var DependencyCollection $dependencies */
        $dependencies = $result['dependencies'] ?? new DependencyCollection();

        $issues = [];
        foreach ($dependencies as $dependency) {
            if ($dependency->inState(DependencyInterface::STATE_UNUSED)) {
                $issues[] = [
                    'description' => "Package {$dependency->getName()} is unused",
                    'fingerprint' => 'dep-reaper-' . md5($dependency->getName()),
                    'severity'    => 'major',
                    'location'    => ['path' => 'composer.json']
                ];
            }
        }

        $this->output->writeln(json_encode($issues, JSON_PRETTY_PRINT));
    }
}
