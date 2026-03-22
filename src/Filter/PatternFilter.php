<?php

namespace DepReaper\Engine\Filter;

use DepReaper\Engine\Dependency\DependencyInterface;

class PatternFilter
{
    public function __construct(private string $pattern) {}

    public static function fromString(string $pattern): self
    {
        return new self($pattern);
    }

    public function matches(DependencyInterface $dependency): bool
    {
        return (bool) preg_match($this->pattern, $dependency->getName());
    }
}
