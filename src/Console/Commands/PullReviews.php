<?php

namespace DrewRoberts\Reporting\Console\Commands;

use Carbon\Carbon;
use DrewRoberts\Reporting\Models\Key;
use DrewRoberts\Reporting\Models\Location;
use DrewRoberts\Reporting\Models\Review;
use Google_Client;
use Google_Service_MyBusiness;
use Illuminate\Console\Command;

/**
 * Class PullReviews.
 */
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
     *
     * @return mixed
     */
    public function handle()
    {
        Location::where('corporate', 1)
            ->whereNotNull('gmb_location')
            ->get()
            ->each(function ($location) {
                $this->line('Pulling Reviews for '.$location->name);

                $client = new Google_Client();
                $client->setAuthConfig(resource_path('client_secret.json'));
                $client->addScope(['https://www.googleapis.com/auth/business.manage']);
                $client->setAccessType('offline');
                $token = json_decode(Key::where('slug', 'gmb-token')->first()->value, true);
                $client->setAccessToken($token);

                if ($client->isAccessTokenExpired()) {
                    $client->refreshToken(array_search('refresh_token', $token));
                    $newtoken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    Key::updateOrCreate(['slug' => 'gmb-token'], ['value' => json_encode($newtoken)]);
                }

                $GoogleLocation = 'accounts/108772742689976468845/locations/'.$location->gmb_location.'/reviews';

                $myBusiness = new Google_Service_MyBusiness($client);

                $response = $myBusiness->accounts_locations_reviews->get($GoogleLocation);

                $reviews_data = $response->toSimpleObject()->reviews;

                foreach ($reviews_data as $review_data) {
                    $review = Review::firstOrNew(['google_ref' => $review_data['reviewId']]);

                    if ($review_data['starRating'] === 'FIVE') {
                        $decimal_rating = 5;
                    }

                    if ($review_data['starRating'] === 'FOUR') {
                        $decimal_rating = 4;
                    }

                    if ($review_data['starRating'] === 'THREE') {
                        $decimal_rating = 3;
                    }

                    if ($review_data['starRating'] === 'TWO') {
                        $decimal_rating = 2;
                    }

                    if ($review_data['starRating'] === 'ONE') {
                        $decimal_rating = 1;
                    }

                    if ($review_data['starRating'] === 'ZERO') {
                        $decimal_rating = 0;
                    }

                    $review->rating = $decimal_rating;

                    if (isset($review_data['comment'])) {
                        $review->comment = $review_data['comment'];
                    }

                    $review->reviewer = $review_data['reviewer']['displayName'];
                    $review->reviewer_photo = $review_data['reviewer']['profilePhotoUrl'];
                    $review->reviewed_at = Carbon::parse($review_data['createTime']);
                    $review->review_updated_at = Carbon::parse($review_data['updateTime']);

                    if (isset($review_data['reviewReply'])) {
                        $review->reply = $review_data['reviewReply']['comment'];
                        $review->replied_at = Carbon::parse($review_data['reviewReply']['updateTime']);
                    }

                    $review->location_id = $location->id;
                    $review->save();
                }
            });
    }
}