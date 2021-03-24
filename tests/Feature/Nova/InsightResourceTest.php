<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Feature\Nova;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tipoff\Authorization\Models\User;
use Tipoff\Locations\Models\Location;
use Tipoff\Reviews\Models\Insight;
use Tipoff\Reviews\Tests\TestCase;

class InsightResourceTest extends TestCase
{
    use DatabaseTransactions;

    private const NOVA_ROUTE = 'nova-api/insights';
    
    /** @test */
    public function index_role_location_filter()
    {
        $location1 = Location::factory()->create();
        $location2 = Location::factory()->create();

        Insight::factory()->count(2)->create([
            'location_id' => $location1,
        ]);

        Insight::factory()->count(3)->create([
            'location_id' => $location2,
        ]);

        /** @var User $user */
        $user = User::factory()->create()->givePermissionTo(
            Role::findByName('Admin')->getPermissionNames()     // Use individual permissions so we can revoke one
        );
        $user->locations()->attach($location1);
        $this->actingAs($user);

        $response = $this->getJson(self::NOVA_ROUTE)
            ->assertOk();

        $this->assertCount(5, $response->json('resources'));

        $user->revokePermissionTo('all locations');
        $response = $this->getJson(self::NOVA_ROUTE)
            ->assertOk();

        $this->assertCount(2, $response->json('resources'));
    }
}
