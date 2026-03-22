<?php

namespace DepReaper\Engine\Dependency;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class DependencyCollection implements IteratorAggregate
{
    private array $dependencies = [];

    public function add(DependencyInterface $dependency): void
    {
        $this->dependencies[] = $dependency;
    }

    public function partition(callable $callback): array
    {
        $matches = [];
        $nonMatches = [];

        foreach ($this->dependencies as $dependency) {
            if ($callback($dependency)) {
                $matches[] = $dependency;
            } else {
                $nonMatches[] = $dependency;
            }
        }

        return [$matches, $nonMatches];
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->dependencies);
    }
}
