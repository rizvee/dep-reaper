<!-- 
Title: DepReaper: The Ultimate PHP Unused Dependency Scanner by Hasan Rizvee
Meta Description: Optimize your PHP projects with DepReaper. A high-performance static analysis tool by Hasan Rizvee to identify and remove unused Composer packages.
-->

# Stop Bloating Your PHP Apps: Meet DepReaper
*"Reap the dead weight from your PHP projects."*

Dependency Bloat costs you money and time. It causes slower Docker builds, larger server images, and opens you up to security vulnerabilities in unused code.

DepReaper is the ultimate solution. It goes beyond binary used/unused status by providing deep recursive analysis, health scores, security surface reports, and GitHub Actions native outputs.

## Why DepReaper?
Compared to traditional tools like composer-unused, DepReaper introduces several next-generation features:

- **The Analysis Engine**: A high-performance symbol extractor that identifies classes, functions, and constants without executing the code.
- **XDebug Stealth Mode**: Automatically detects and bypasses XDebug to prevent performance bottlenecks and segmentation faults during analysis.
- **Shadow Dependency Detection**: Identifies packages that are required but never actually imported or utilized in the codebase.
- **Ghost Filters**: Advanced exclusion rules (Named and Pattern-based) to ignore legitimate "invisible" dependencies like polyfills or dev-tooling.

## Benchmarks
DepReaper is aggressively optimized for speed. By automatically utilizing XDebug Stealth Mode, it achieves a scanning speed up to 10x faster than running with XDebug overhead on typical manual audits.

## Installation
Download the PHAR directly and run it anywhere:

```bash
curl -LO https://github.com/rizvee/dep-reaper/releases/latest/download/dep-reaper.phar
chmod +x dep-reaper.phar
mv dep-reaper.phar /usr/local/bin/dep-reaper
```

## How to remove unused PHP packages
Run the analyzer from the root of your project:
```bash
dep-reaper --output=compact
```

Or run with auto-remove (dry run prompt included):
```bash
dep-reaper --fix
```

## Configuration
Use a `dep-reaper.php` file in your project root to configure the **DependencyAnalyzer**. You can exclude specific folders or internal packages from the analysis:

```php
<?php

use DepReaper\Engine\Configuration\Configuration;
use DepReaper\Engine\Filter\NamedFilter;
use DepReaper\Engine\Filter\PatternFilter;

return static function (Configuration $config): void {
    // Tell the analyzer to ignore a specific package
    $config->addNamedFilter(NamedFilter::fromString('symfony/dotenv'));
    // Tell the analyzer to ignore all packages by an org
    $config->addPatternFilter(PatternFilter::fromString('/symfony\/.*/'));
    // Exclude additional files
    $config->setAdditionalFilesFor('my/package', [__DIR__ . '/bootstrap/app.php']);
};
```

## Speed up GitHub Actions by cleaning Composer dependencies
DepReaper runs natively in CI/CD pipelines, automatically detecting `GITHUB_ACTIONS` to output native error annotations (`::error::`).

```yaml
      - run: dep-reaper --output=github
```

## Credits

**dep-reaper** is created and maintained by [Hasan Rizvee](https://github.com/hasnrizvee).

Inspired by the original [composer-unused](https://github.com/composer-unused/composer-unused)
by Andreas Frömer and contributors. This project is an independent reimagination
with a different scope, architecture, and feature set. Logo and brand by Hasan Rizvee.

Built on top of [nikic/php-parser](https://github.com/nikic/PHP-Parser),
[Symfony Console](https://symfony.com/doc/current/components/console.html),
and [composer-unused/symbol-parser](https://github.com/composer-unused/symbol-parser).

License: MIT.
