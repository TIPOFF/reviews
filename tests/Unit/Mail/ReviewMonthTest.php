<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Unit\Mail;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tipoff\Reviews\Mail\ReviewMonth;
use Tipoff\Reviews\Tests\TestCase;

class ReviewMonthTest extends TestCase
{
    use DatabaseTransactions;

    //Todo: Need to figure out how to test markdown content

    /** @test */
    public function email()
    {
        Mail::fake();
        Mail::assertNothingSent();

        Mail::to('test@example.com')->send(new ReviewMonth());
        Mail::assertSent(ReviewMonth::class);
    }
}
