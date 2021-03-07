<?php

namespace Tipoff\Reviews\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Tipoff\Reviews\Models\Competitor;
use Tipoff\Reviews\Models\Snapshot;

class SnapshotCompetitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snapshot:competitors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take a snapshot of competitor reviews';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // @todo Needs Refactoring
        $apikey = config('app.google_api');
        $competitors = Competitor::all();

        foreach ($competitors as $competitor) {
            $url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id='.$competitor->place_location.'&key='.$apikey;
            $client = new Client();
            $response = $client->request('GET', $url);
            $body = json_decode($response->getBody(), true);
            $place = $body['result'];

            $competitor->name = $place['name'];
            foreach ($place['address_components'] as $a) {
                if ($a['types'][0] == 'postal_code') {
                    $zip = substr($a['short_name'], 0, 5);
                    if (is_numeric($zip)) {
                        $competitor->zip = $zip;
                    }
                }
                if ($a['types'][0] == 'locality') {
                    $competitor->city = $a['long_name'];
                }
                if ($a['types'][0] == 'administrative_area_level_1') {
                    $competitor->state = $a['short_name'];
                }
                if ($a['types'][0] == 'street_number') {
                    $street_number = $a['short_name'];
                }
                if ($a['types'][0] == 'route') {
                    $street = $a['short_name'];
                }
                if ($a['types'][0] == 'subpremise') {
                    $competitor->address2 = $a['short_name'];
                }
            }
            $competitor->address = $street_number.' '.$street;
            if (isset($place['formatted_phone_number'])) {
                $competitor->phone = $place['formatted_phone_number'];
            }
            if (isset($place['website'])) {
                $competitor->website = $place['website'];
            }
            $competitor->maps_url = $place['url'];
            if (isset($place['opening_hours'])) {
                foreach ($place['opening_hours']['periods'] as $t) {
                    if ($t['open']['day'] == 0) {
                        $competitor->sunday_open = $t['open']['time'];
                        if (isset($t['close'])) {
                            $competitor->sunday_close = $t['close']['time'];
                        }
                    }
                    if ($t['open']['day'] == 1) {
                        $competitor->monday_open = $t['open']['time'];
                        if (isset($t['close'])) {
                            $competitor->monday_close = $t['close']['time'];
                        }
                    }
                    if ($t['open']['day'] == 2) {
                        $competitor->tuesday_open = $t['open']['time'];
                        if (isset($t['close'])) {
                            $competitor->tuesday_close = $t['close']['time'];
                        }
                    }
                    if ($t['open']['day'] == 3) {
                        $competitor->wednesday_open = $t['open']['time'];
                        if (isset($t['close'])) {
                            $competitor->wednesday_close = $t['close']['time'];
                        }
                    }
                    if ($t['open']['day'] == 4) {
                        $competitor->thursday_open = $t['open']['time'];
                        if (isset($t['close'])) {
                            $competitor->thursday_close = $t['close']['time'];
                        }
                    }
                    if ($t['open']['day'] == 5) {
                        $competitor->friday_open = $t['open']['time'];
                        if (isset($t['close'])) {
                            $competitor->friday_close = $t['close']['time'];
                        }
                    }
                    if ($t['open']['day'] == 6) {
                        $competitor->saturday_open = $t['open']['time'];
                        if (isset($t['close'])) {
                            $competitor->saturday_close = $t['close']['time'];
                        }
                    }
                }
            }
            if (isset($place['geometry']['location'])) {
                $competitor->latitude = $place['geometry']['location']['lat'];
                $competitor->longitude = $place['geometry']['location']['lng'];
            }
            $competitor->save();

            $snapshot = Snapshot::firstOrNew(['competitor_id' => $competitor->id, 'date' => Carbon::now('America/New_York')->format('Y-m-d')]);
            $snapshot->reviews = $place['user_ratings_total'];
            $snapshot->rating = $place['rating'];
            $snapshot->save();

            if (isset($competitor->location)) {
                $location = $competitor->location;
                if (isset($location)) {
                    $location->gmb_reviews = $place['user_ratings_total'];
                    $location->gmb_rating = $place['rating'];
                    $location->latitude = $competitor->latitude;
                    $location->longitude = $competitor->longitude;
                    $location->save();
                }
            }
        }
    }
}
