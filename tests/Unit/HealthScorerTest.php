<?php

namespace HasnRizvee\DepReaper\Tests\Unit;

use HasnRizvee\DepReaper\Analyser\HealthScorer;
use PHPUnit\Framework\TestCase;

class HealthScorerTest extends TestCase
{
    public function testScoreCalculation(): void
    {
        $scorer = new HealthScorer();
        $this->assertSame(50, $scorer->score(['A'], ['A', 'B']));
        $this->assertSame(0, $scorer->score([], ['A', 'B']));
        $this->assertSame(100, $scorer->score(['A', 'B'], ['A', 'B']));
        $this->assertSame(0, $scorer->score(['A'], []));
    }
}
