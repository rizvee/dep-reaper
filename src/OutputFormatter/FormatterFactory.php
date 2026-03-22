<?php

namespace DepReaper\Engine\OutputFormatter;

use Symfony\Component\Console\Output\OutputInterface;

class FormatterFactory
{
    public function create(string $type, OutputInterface $output): FormatterInterface
    {
        // Automatic CI Detection
        if (getenv('GITHUB_ACTIONS') === 'true' && $type === 'default') {
            $type = 'github';
        }

        return match ($type) {
            'github' => new GithubActionsFormatter($output),
            'gitlab' => new GitlabFormatter($output),
            'sarif'  => new SarifFormatter($output),
            default  => new DefaultFormatter($output),
        };
    }
}
