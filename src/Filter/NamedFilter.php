<?php

namespace DepReaper\Engine\Filter;

use DepReaper\Engine\Dependency\DependencyInterface;

class NamedFilter
{
    public function __construct(private string $name) {}

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function matches(DependencyInterface $dependency): bool
    {
        return $dependency->getName() === $this->name;
    }
}
