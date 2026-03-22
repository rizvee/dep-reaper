<?php

namespace DepReaper\Engine\OutputFormatter;

use DepReaper\Engine\Dependency\DependencyCollection;
use DepReaper\Engine\Dependency\DependencyInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultFormatter implements FormatterInterface
{
    public function __construct(private OutputInterface $output) {}

    public function format(array $result): void
    {
        /** @var DependencyCollection $dependencies */
        $dependencies = $result['dependencies'] ?? new DependencyCollection();

        $unused = [];
        $used = [];
        $ignored = [];

        foreach ($dependencies as $dependency) {
            if ($dependency->inState(DependencyInterface::STATE_USED)) {
                $used[] = $dependency->getName();
                $this->output->writeln("<fg=green>✓</> {$dependency->getName()} (used)");
            } elseif ($dependency->inState(DependencyInterface::STATE_IGNORED)) {
                $ignored[] = $dependency->getName();
                $this->output->writeln("<fg=yellow>○</> {$dependency->getName()} (ignored)");
            } else {
                $unused[] = $dependency->getName();
                $this->output->writeln("<fg=red>✗</> {$dependency->getName()} (heavy/unused)");
            }
        }

        if (!empty($unused)) {
            $this->output->writeln("\n<comment>To reap these dependencies, run:</comment>");
            $this->output->writeln("composer remove " . implode(' ', $unused));
        }
    }
}
