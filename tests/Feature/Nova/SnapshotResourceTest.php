<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Feature\Nova;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Reviews\Models\Snapshot;
use Tipoff\Reviews\Tests\TestCase;

class SnapshotResourceTest extends TestCase
{
    use DatabaseTransactions;
    
    private const NOVA_ROUTE = 'nova-api/snapshots';
    
    /** @test */
    public function index()
    {
        Snapshot::factory()->count(4)->create();

        /** @var User $user */
        $user = User::factory()->create()->givePermissionTo(
            Role::findByName('Admin')->getPermissionNames()     // Use individual permissions so we can revoke one
        );
        $this->actingAs($user);

        $response = $this->getJson(self::NOVA_ROUTE)
            ->assertOk();

        $this->assertCount(4, $response->json('resources'));
    }
}
