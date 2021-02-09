<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Reviews\Models\Key;
use Tipoff\Reviews\Tests\TestCase;

class KeyModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        /** @var Key $key */
        $key = Key::factory()->create();
        $this->assertNotNull($key);
    }
}
