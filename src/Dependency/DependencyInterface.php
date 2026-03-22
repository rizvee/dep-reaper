<?php

namespace DepReaper\Engine\Dependency;

interface DependencyInterface
{
    public const STATE_USED = 'used';
    public const STATE_UNUSED = 'unused';
    public const STATE_IGNORED = 'ignored';

    public function inState(string $state): bool;
    public function provides(string $symbol): bool;
    public function markUsed(): void;
    public function requires(DependencyInterface $dependency): bool;
    public function requiredBy(DependencyInterface $parent): void;
    public function getName(): string;
}
