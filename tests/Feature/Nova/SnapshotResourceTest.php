<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Feature\Nova;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Reviews\Models\Snapshot;
use Tipoff\Reviews\Tests\TestCase;

class SnapshotResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index()
    {
        Snapshot::factory()->count(4)->create();

        $this->actingAs(self::createPermissionedUser('view snapshots', true));

        $response = $this->getJson('nova-api/snapshots')
            ->assertOk();

        $this->assertCount(4, $response->json('resources'));
    }
}
