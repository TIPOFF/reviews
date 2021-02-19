<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Tipoff\Locations\Models\Location;

class ReviewWeekend extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $locations;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->locations = Location::where('corporate', 1)->withCount(['reviews' => function ($query) {
            $query->where('reviewed_at', '>', Carbon::parse('last friday', 'America/New_York')
                ->setTimeZone('UTC')
                ->format('Y-m-d H:i:s'))
                ->where('reviewed_at', '<', Carbon::parse('last friday', 'America/New_York')
                    ->setTimeZone('UTC')->addDays(3)
                    ->format('Y-m-d H:i:s'));
        }])->orderByDesc('reviews_count')->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $locations = $this->locations;
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                ->addTextHeader('tag', 'reviewweekend');
        });

        return $this->markdown('emails.reviews.weekend')
            ->subject('Google Reviews - ' . Carbon::parse('last saturday', 'America/New_York')->format('M j') . ' Weekend')
            ->with([
                'locations' => $locations,
            ]);
    }
}
