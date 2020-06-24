<?php

namespace DrewRoberts\Reporting\Console\Commands;

use DrewRoberts\Reporting\Models\Key;
use DrewRoberts\Reporting\Models\Location;
use Google_Client;
use Google_Service_MyBusiness;
use Illuminate\Console\Command;

/**
 * Class SyncLocations.
 */
class SyncLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync information from Google My Business to the location table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $accounts = ['accounts/108772742689976468845/locations', 'accounts/116666006358174413896/locations'];

        foreach ($accounts as $account) {
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

            $myBusiness = new Google_Service_MyBusiness($client);
            $gmblocations = $myBusiness->accounts_locations->get($account)->toSimpleObject()->locations;

            foreach ($gmblocations as $gmb) {
                $gmbid = substr($gmb['name'], strrpos($gmb['name'], '/') + 1);
                $location = Location::where('gmb_location', $gmbid)->first();

                if ($location) {
                    $location->title = $gmb['locationName'];

                    if (isset($gmb['openInfo']['openingDate']['day'])) {
                        $location->opened_at = $gmb['openInfo']['openingDate']['year'].'-'.$gmb['openInfo']['openingDate']['month'].'-'.$gmb['openInfo']['openingDate']['day'];
                    }

                    $location->address = $gmb['address']['addressLines'][0];

                    if (isset($gmb['address']['addressLines'][1])) {
                        $location->address2 = $gmb['address']['addressLines'][1];
                    }

                    $location->city = $gmb['address']['locality'];
                    $location->state = $gmb['address']['administrativeArea'];
                    $location->zip = substr($gmb['address']['postalCode'], 0, 5);
                    $location->phone = $gmb['primaryPhone'];

                    if (isset($gmb['regularHours'])) {
                        foreach ($gmb['regularHours']['periods'] as $t) {
                            if ($t['openDay'] === 'SUNDAY') {
                                $location->sunday_open = $t['openTime'];
                                $location->sunday_close = $t['closeTime'];
                            }

                            if ($t['openDay'] === 'MONDAY') {
                                $location->monday_open = $t['openTime'];
                                $location->monday_close = $t['closeTime'];
                            }

                            if ($t['openDay'] === 'TUESDAY') {
                                $location->tuesday_open = $t['openTime'];
                                $location->tuesday_close = $t['closeTime'];
                            }

                            if ($t['openDay'] === 'WEDNESDAY') {
                                $location->wednesday_open = $t['openTime'];
                                $location->wednesday_close = $t['closeTime'];
                            }

                            if ($t['openDay'] === 'THURSDAY') {
                                $location->thursday_open = $t['openTime'];
                                $location->thursday_close = $t['closeTime'];
                            }

                            if ($t['openDay'] === 'FRIDAY') {
                                $location->friday_open = $t['openTime'];
                                $location->friday_close = $t['closeTime'];
                            }

                            if ($t['openDay'] === 'SATURDAY') {
                                $location->saturday_open = $t['openTime'];
                                $location->saturday_close = $t['closeTime'];
                            }
                        }
                    }
                    $location->review_url = $gmb['metadata']['newReviewUrl'];
                    $location->maps_url = $gmb['metadata']['mapsUrl'];

                    if (isset($gmb['latlng'])) {
                        $location->latitude = $gmb['latlng']['latitude'];
                        $location->longitude = $gmb['latlng']['longitude'];
                    }

                    $location->place_location = $gmb['locationKey']['placeId'];
                    $location->save();
                }
            }
        }
    }
}
