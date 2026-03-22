<?php

use HasnRizvee\DepReaper\Configuration\Configuration;
use HasnRizvee\DepReaper\Configuration\NamedFilter;
use HasnRizvee\DepReaper\Configuration\PatternFilter;

return static function (Configuration $config): void {
    // Ignore a specific package
    $config->addNamedFilter(NamedFilter::fromString('symfony/dotenv'));

    // Ignore all packages by an org
    $config->addPatternFilter(PatternFilter::fromString('/symfony\/.*/'));

    // Add paths not covered by autoload
    $config->setAdditionalFilesFor('some/package', [__DIR__ . '/bootstrap/app.php']);
};
