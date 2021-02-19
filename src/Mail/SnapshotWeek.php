<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Tipoff\Locations\Models\Market;
use Tipoff\Reviews\Models\Competitor;

class SnapshotWeek extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $market;
    public $competitors;

    /**
     * Create a new message instance.
     *
     * @param Market $market
     */
    public function __construct(Market $market)
    {
        $this->market = $market;

        $competitors = Competitor::where('market_id', $market->id)->get();
        $this->competitors = $competitors->sortByDesc('weekly_reviews');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $competitors = $this->competitors;
        $market = $this->market;
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('tag', 'snapshotweek');
        });

        if (isset($market->locations->first()->manager->email) && $market->locations->first()->manager->email !== $market->locations->first()->contact_email) {
            $locationemails = [
                $market->locations->first()->contact_email,
                $market->locations->first()->manager->email,
            ];
        } else {
            $locationemails = $market->locations->first()->contact_email;
        }

        $execs = [
            'kirk@thegreatescaperoom.com',
            'julie@thegreatescaperoom.com',
            'nicole@thegreatescaperoom.com',
            'kelleigh@thegreatescaperoom.com',
            'callcenter@thegreatescaperoom.com',
            'scott@thegreatescaperoom.com',
            'igug@thegreatescaperoom.com',
        ];

        return $this->markdown('emails.snapshots.week')
            ->to($locationemails)
            ->cc($execs)
            ->bcc('digitalmgr@thegreatescaperoom.com')
            ->subject($market->name . ' Review Race - ' . Carbon::now('America/New_York')->format('M j'))
            ->with([
                'competitors' => $competitors,
                'market' => $market,
            ]);
    }
}
