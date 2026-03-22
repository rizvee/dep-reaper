<?php

namespace DepReaper\Engine\OutputFormatter;

use DepReaper\Engine\Dependency\DependencyCollection;
use DepReaper\Engine\Dependency\DependencyInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GithubActionsFormatter implements FormatterInterface
{
    public function __construct(private OutputInterface $output) {}

    public function format(array $result): void
    {
        /** @var DependencyCollection $dependencies */
        $dependencies = $result['dependencies'] ?? new DependencyCollection();

        foreach ($dependencies as $dependency) {
            if ($dependency->inState(DependencyInterface::STATE_UNUSED)) {
                $this->output->writeln("::error::DepReaper: Package {$dependency->getName()} is unused and should be removed.");
            } elseif ($dependency->inState(DependencyInterface::STATE_IGNORED)) {
                $this->output->writeln("::warning::DepReaper: Package {$dependency->getName()} is ignored.");
            }
        }
    }
}
