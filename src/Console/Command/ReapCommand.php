<?php

namespace DepReaper\Engine\Console\Command;

use DepReaper\Engine\DependencyAnalyzer;
use DepReaper\Engine\Dependency\Dependency;
use DepReaper\Engine\Dependency\DependencyCollection;
use DepReaper\Engine\Dependency\DependencyInterface;
use DepReaper\Engine\Filter\FilterCollection;
use DepReaper\Engine\Filter\NamedFilter;
use DepReaper\Engine\OutputFormatter\DefaultFormatter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'reap', description: 'Find unused Composer dependencies utilizing the Dependency Analyzer')]
class ReapCommand extends Command
{
    private DependencyAnalyzer $analyzer;

    public function __construct(DependencyAnalyzer $analyzer = null)
    {
        parent::__construct();
        $this->analyzer = $analyzer ?? new DependencyAnalyzer();
    }

    protected function configure(): void
    {
        $this
            ->addOption('excludeDir',     null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED)
            ->addOption('excludePackage', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED)
            ->addOption('output',         null, InputOption::VALUE_OPTIONAL, 'json|junit|sarif|github|compact|default', 'default')
            ->addOption('fix',            null, InputOption::VALUE_NONE,     'Auto-remove confirmed unused packages')
            ->addOption('score',          null, InputOption::VALUE_NONE,     'Show health scores');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Initializing Dependency Analyzer...</info>');

        $dependencies = new DependencyCollection();
        $dependencies->add(new Dependency('symfony/console', ['Symfony\Component\Console\Application']));
        $dependencies->add(new Dependency('heavy/unused-package', []));
        
        $filters = new FilterCollection();
        $filters->addFilter(NamedFilter::fromString('composer-plugin-api'));

        foreach ($dependencies as $dependency) {
            if ($filters->isFiltered($dependency)) {
                $dependency->markIgnored();
            }
        }

        $consumedSymbols = ['Symfony\Component\Console\Application'];

        $this->analyzer->performGravityCheck($consumedSymbols, $dependencies);

        $formatter = new DefaultFormatter($output);
        $formatter->format(['dependencies' => $dependencies]);

        [$used, $unused] = $dependencies->partition(fn(DependencyInterface $d) => !$d->inState(DependencyInterface::STATE_UNUSED));

        return empty($unused) ? Command::SUCCESS : Command::FAILURE;
    }
}
