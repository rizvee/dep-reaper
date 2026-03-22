<?php

namespace DepReaper\Engine\Dependency;

class Dependency implements DependencyInterface
{
    private string $state = self::STATE_UNUSED;

    public function __construct(
        private string $name,
        private array $providedSymbols = [],
        private array $requires = []
    ) {}

    public function inState(string $state): bool
    {
        return $this->state === $state;
    }

    public function provides(string $symbol): bool
    {
        return in_array($symbol, $this->providedSymbols, true);
    }

    public function markUsed(): void
    {
        $this->state = self::STATE_USED;
    }

    public function markIgnored(): void
    {
        $this->state = self::STATE_IGNORED;
    }

    public function requires(DependencyInterface $dependency): bool
    {
        return in_array($dependency->getName(), $this->requires, true);
    }

    public function requiredBy(DependencyInterface $parent): void
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
