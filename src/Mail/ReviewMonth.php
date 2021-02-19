<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Mail;

use Tipoff\Locations\Models\Location;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewMonth extends Mailable
{
    use Queueable, SerializesModels;

    public $locations;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->locations = Location::where('corporate', 1)->withCount(['reviews' => function ($query) {
            $query->where('reviewed_at', '>', Carbon::now('America/New_York')
                ->startOfMonth()
                ->subMonth()
                ->setTimeZone('UTC')
                ->format('Y-m-d H:i:s'))
                ->where('reviewed_at', '<', Carbon::now('America/New_York')
                    ->subMonth()
                    ->endOfMonth()
                    ->setTimeZone('UTC')
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
        $month = Carbon::now()->subMonth()->format('F');
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                ->addTextHeader('tag', 'reviewmonth');
        });

        return $this->markdown('emails.reviews.month')
            ->subject($month . ' Review Totals')
            ->with([
                'locations' => $locations,
                'month' => $month,
            ]);
    }
}
