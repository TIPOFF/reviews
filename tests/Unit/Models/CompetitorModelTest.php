<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Reviews\Models\Competitor;
use Tipoff\Reviews\Tests\TestCase;

class CompetitorModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        /** @var Competitor $competitor */
        $competitor = Competitor::factory()->create();
        $this->assertNotNull($competitor);
    }
}
