<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Commands;

use Carbon\Carbon;
use Google_Service_MyBusiness;
use Illuminate\Console\Command;
use Tipoff\Locations\Models\Location;
use Tipoff\Reviews\Models\Review;

class PullReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull the Google reviews for each location';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $locations = Location::where('corporate', 1)
            ->whereNotNull('gmb_location')
            ->get();

        $myBusiness = app()->make(Google_Service_MyBusiness::class);

        foreach ($locations as $location) {
            // @todo Needs Refactoring
            $GoogleLocation = 'accounts/108772742689976468845/locations/'.$location->gmb_location.'/reviews';

            $response = $myBusiness->accounts_locations_reviews->get($GoogleLocation);

            $reviews_data = $response->toSimpleObject()->reviews;

            $ratings = ['zero','one','two','three','four','five',]; // keys are rating value

            foreach ($reviews_data as $review_data) {
                $review = Review::firstOrCreate(
                    ['google_ref' => $review_data['reviewId']],
                    [
                        'rating' => array_search(strtolower($review_data['starRating']), $ratings),
                        'comment' => $review_data['comment'] ?? null,
                        'reviewer' => $review_data['reviewer']['displayName'],
                        'reviewer_photo' => $review_data['reviewer']['profilePhotoUrl'],
                        'reviewed_at' => Carbon::parse($review_data['createTime']),
                        'review_updated_at' => Carbon::parse($review_data['updateTime']),
                        'reply' => $review_data['reviewReply'] ? $review_data['reviewReply']['comment'] : null,
                        'replied_at' => $review_data['reviewReply'] ? Carbon::parse($review_data['reviewReply']['updateTime']) : null,
                    ]
                );
                $review->location()->associate($location);  // hydrate the location_id
            }
        }
    }
}
