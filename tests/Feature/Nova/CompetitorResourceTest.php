<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Feature\Nova;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tipoff\Authorization\Models\User;
use Tipoff\Reviews\Models\Competitor;
use Tipoff\Reviews\Tests\TestCase;

class CompetitorResourceTest extends TestCase
{
    use DatabaseTransactions;
    
    private const NOVA_ROUTE = 'nova-api/competitors';
    
    /** @test */
    public function index()
    {
        Competitor::factory()->count(3)->create();

        /** @var User $user */
        $user = User::factory()->create()->givePermissionTo(
            Role::findByName('Admin')->getPermissionNames()     // Use individual permissions so we can revoke one
        );
        $this->actingAs($user);

        $response = $this->getJson(self::NOVA_ROUTE)
            ->assertOk();

        $this->assertCount(3, $response->json('resources'));
    }
}
