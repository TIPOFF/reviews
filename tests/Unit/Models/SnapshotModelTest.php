<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Reviews\Models\Snapshot;
use Tipoff\Reviews\Tests\TestCase;

class SnapshotModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        /** @var Snapshot $snapshot */
        $snapshot = Snapshot::factory()->create();
        $this->assertNotNull($snapshot);
    }
}
