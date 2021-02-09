<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Reviews\Models\Insight;
use Tipoff\Reviews\Tests\TestCase;

class InsightModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        /** @var Insight $insight */
        $insight = Insight::factory()->create();
        $this->assertNotNull($insight);
    }
}
