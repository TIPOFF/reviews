<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Tipoff\Reviews\Models\Competitor;

class SnapshotTop extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $competitors;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $competitors = Competitor::whereNotNull('market_id')->get();
        $this->competitors = $competitors->sortByDesc('weekly_reviews')->take(25);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $managers = [
            'orlandomgr@thegreatescaperoom.com',
            'orlando@thegreatescaperoom.com',
            'tampamgr@thegreatescaperoom.com',
            'tampa@thegreatescaperoom.com',
            'jacksonvillemgr@thegreatescaperoom.com',
            'jacksonville@thegreatescaperoom.com',
            'akronmgr@thegreatescaperoom.com',
            'akron@thegreatescaperoom.com',
            'grandrapidsmgr@thegreatescaperoom.com',
            'grandrapids@thegreatescaperoom.com',
            'providencemgr@thegreatescaperoom.com',
            'providence@thegreatescaperoom.com',
            'rochestermgr@thegreatescaperoom.com',
            'rochester@thegreatescaperoom.com',
            'chicagomgr@thegreatescaperoom.com',
            'chicago@thegreatescaperoom.com',
            'royaloakmgr@thegreatescaperoom.com',
            'royaloak@thegreatescaperoom.com',
        ];
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
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('tag', 'snapshottop');
        });

        return $this->markdown('emails.snapshots.top')
            ->to($managers)
            ->cc($execs)
            ->bcc('digitalmgr@thegreatescaperoom.com')
            ->subject('Top 25 - Weekly Review Race - ' . Carbon::now('America/New_York')->format('M j'))
            ->with([
                'competitors' => $competitors,
            ]);
    }
}
