<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Unit\Mail;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tipoff\Reviews\Mail\SnapshotTop;
use Tipoff\Reviews\Tests\TestCase;

class SnapshotTopTest extends TestCase
{
    use DatabaseTransactions;

    //Todo: Need to figure out how to test markdown content

    /** @test */
    public function email()
    {
        Mail::fake();
        Mail::assertNothingSent();

        Mail::send(new SnapshotTop());
        Mail::assertSent(function (SnapshotTop $mail) {
            $mail->build();

            return $mail->hasCc('kirk@thegreatescaperoom.com') &&
                $mail->hasBcc('digitalmgr@thegreatescaperoom.com');
        });
    }
}
