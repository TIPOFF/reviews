<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Tipoff\Locations\Models\Market;
use Tipoff\Reviews\Models\Competitor;

class SnapshotMonth extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $competitors;
    public $market;

    /**
     * Create a new message instance.
     *
     * @param Market $market
     */
    public function __construct(Market $market)
    {
        $this->market = $market;

        $competitors = Competitor::where('market_id', $market->id)->get();
        $this->competitors = $competitors->sortByDesc('reviews');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $execs = [
            'kirk@thegreatescaperoom.com',
            'julie@thegreatescaperoom.com',
            'nicole@thegreatescaperoom.com',
            'kelleigh@thegreatescaperoom.com',
            'callcenter@thegreatescaperoom.com',
            'scott@thegreatescaperoom.com',
            'igug@thegreatescaperoom.com',
        ];

        $competitors = $this->competitors;
        $market = $this->market;
        $month = Carbon::now()->subMonth()->format('F');
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('tag', 'snapshotmonth');
        });


        if (isset($market->locations->first()->manager->email) && $market->locations->first()->manager->email !== $market->locations()->first()->email()->first()->email) {
            $locationemails = [
                $market->locations()->first()->email()->first()->email,
                $market->locations()->first()->manager->email,
            ];
        } else {
            $locationemails = $market->locations()->first()->email()->first()->email;
        }

        return $this->markdown('emails.snapshots.month')
            ->to($locationemails)
            ->cc($execs)
            ->bcc('digitalmgr@thegreatescaperoom.com')
            ->subject($market->name . ' Reviews in ' . $month)
            ->with([
                'competitors' => $competitors,
                'market' => $market,
                'month' => $month,
            ]);
    }
}
