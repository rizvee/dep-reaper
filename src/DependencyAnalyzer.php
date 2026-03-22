<?php

namespace DepReaper\Engine;

use DepReaper\Engine\Dependency\DependencyCollection;
use DepReaper\Engine\Dependency\DependencyInterface;

final class DependencyAnalyzer
{
    public function __construct()
    {
        // Disable XDebug automatically for performance
        if (extension_loaded('xdebug')) {
            ini_set('xdebug.default_enable', '0');
        }
    }

    public function performGravityCheck(
        iterable $consumedSymbols, 
        DependencyCollection $dependencies
    ): void {
        // Phase 1: Direct Usage Scan
        foreach ($consumedSymbols as $symbol) {
            foreach ($dependencies as $dependency) {
                if ($dependency->inState(DependencyInterface::STATE_USED)) {
                    continue;
                }

                if ($dependency->provides($symbol)) {
                    $dependency->markUsed();
                }
            }
        }

        // Phase 2: The Recursive Lift (Shadow Dependencies)
        $this->resolveInternalRequirements($dependencies);
    }

    private function resolveInternalRequirements(DependencyCollection $dependencies): void
    {
        $hasChanged = true;

        while ($hasChanged) {
            $hasChanged = false;

            foreach ($dependencies as $dependency) {
                if ($dependency->inState(DependencyInterface::STATE_USED)) {
                    continue;
                }

                foreach ($dependencies as $potentialParent) {
                    if (!$potentialParent->inState(DependencyInterface::STATE_USED)) {
                        continue;
                    }

                    // If a used package requires this one, it is "lifted" into used state
                    if ($potentialParent->requires($dependency)) {
                        $dependency->requiredBy($potentialParent);
                        $dependency->markUsed();
                        $hasChanged = true;
                        continue 2;
                    }
                }
            }
        }
    }
}
