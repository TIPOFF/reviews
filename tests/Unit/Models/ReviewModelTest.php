<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Reviews\Models\Review;
use Tipoff\Reviews\Tests\TestCase;

class ReviewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        /** @var Review $review */
        $review = Review::factory()->create();
        $this->assertNotNull($review);
    }
}
