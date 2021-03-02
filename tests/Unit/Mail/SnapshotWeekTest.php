<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Unit\Mail;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tipoff\Locations\Models\Location;
use Tipoff\Locations\Models\Market;
use Tipoff\Reviews\Mail\SnapshotWeek;
use Tipoff\Reviews\Models\Competitor;
use Tipoff\Reviews\Tests\TestCase;
use Tipoff\Authorization\Models\User;

class SnapshotWeekTest extends TestCase
{
    use DatabaseTransactions;

    //Todo: Need to figure out how to test markdown content

    /** @test */
    public function email()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $market = Market::factory()->create();
        Location::factory()->create([
            'market_id' => $market->id,
            'manager_id' => User::factory()->create()->id,
        ]);
        Competitor::factory()->create([
            'market_id' => $market->id,
        ]);
        Mail::send(new SnapshotWeek($market));
        Mail::assertSent(function (SnapshotWeek $mail) use ($market) {
            $mail->build();

            return $mail->market->id === $market->id &&
                $mail->hasTo($market->locations->first()->contact_email) &&
                $mail->hasCc('kirk@thegreatescaperoom.com') &&
                $mail->hasBcc('digitalmgr@thegreatescaperoom.com');
        });
    }
}
