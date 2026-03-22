<?php

namespace DepReaper\Engine\Filter;

use DepReaper\Engine\Dependency\DependencyInterface;

class FilterCollection
{
    private array $filters = [];

    public function addFilter($filter): void
    {
        $this->filters[] = $filter;
    }

    public function isFiltered(DependencyInterface $dependency): bool
    {
        foreach ($this->filters as $filter) {
            if ($filter->matches($dependency)) {
                return true;
            }
        }
        return false;
    }
}
