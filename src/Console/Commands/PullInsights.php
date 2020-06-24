<?php

namespace DrewRoberts\Reporting\Console\Commands;

use Carbon\Carbon;
use DrewRoberts\Reporting\Models\Insight;
use DrewRoberts\Reporting\Models\Key;
use DrewRoberts\Reporting\Models\Location;
use Google_Client;
use Google_Service_MyBusiness;
use Google_Service_MyBusiness_BasicMetricsRequest;
use Google_Service_MyBusiness_MetricRequest;
use Google_Service_MyBusiness_ReportLocationInsightsRequest;
use Google_Service_MyBusiness_TimeRange;
use Illuminate\Console\Command;

/**
 * Class PullInsights.
 */
class PullInsights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:insights';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull the GMB Insights for each location';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // I'm refreshing the stats from the previous few days since the data appears to be delayed. If yesterday's stats become accurate as of 7am, then can remove this.
        for ($day = 45; $day >= 1; $day--) {
            Location::whereNotNull('gmb_location')
                ->get()
                ->each(function ($location) use ($day) {
                    $this->line('Pulling Insights for '.$location->name.' for '.$day.' day(s) ago');

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

                    if ($location->corporate === 0) {
                        $account = 'accounts/116666006358174413896';
                    } else {
                        $account = 'accounts/108772742689976468845';
                    }
                    $accountlocation = $account.'/locations/'.$location->gmb_location;

                    $myBusiness = new Google_Service_MyBusiness($client);
                    $reportLocationInsightsRequest = new Google_Service_MyBusiness_ReportLocationInsightsRequest();
                    $basicRequest = new Google_Service_MyBusiness_BasicMetricsRequest();
                    $metricRequests = new Google_Service_MyBusiness_MetricRequest();
                    $metricRequests->setMetric('ALL');
                    $basicRequest->setMetricRequests($metricRequests);
                    $timeRange = new Google_Service_MyBusiness_TimeRange();
                    $start = Carbon::now('America/New_York')->startOfDay()->subDays($day)->setTimeZone('UTC')->toIso8601ZuluString();
                    $end = Carbon::now('America/New_York')->endOfDay()->subDays($day)->addSeconds(1)->setTimeZone('UTC')->toIso8601ZuluString();
                    $timeRange->setStartTime($start);
                    $timeRange->setEndTime($end);
                    $basicRequest->setTimeRange($timeRange);
                    $reportLocationInsightsRequest->setBasicRequest($basicRequest);

                    $reportLocationInsightsRequest->setLocationNames([$accountlocation]);
                    $reportLocationInsightsResponse = $myBusiness->accounts_locations->reportInsights($account, $reportLocationInsightsRequest);
                    $locationMetrics = $reportLocationInsightsResponse->getLocationMetrics();

                    $insight = Insight::firstOrNew(['location_id' => $location->id, 'date' => Carbon::now('America/New_York')->startOfDay()->subDays($day)->format('Y-m-d')]);

                    foreach ($locationMetrics[0]->getMetricValues() as $value) {
                        if ($value['metric'] === 'QUERIES_INDIRECT') {
                            $insight->searches_discovery = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'QUERIES_DIRECT') {
                            $insight->searches_direct = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'QUERIES_CHAIN') {
                            $insight->searches_branded = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'VIEWS_MAPS') {
                            $insight->views_maps = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'VIEWS_SEARCH') {
                            $insight->views_search = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'ACTIONS_WEBSITE') {
                            $insight->visits = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'ACTIONS_DRIVING_DIRECTIONS') {
                            $insight->directions = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'ACTIONS_PHONE') {
                            $insight->calls = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'LOCAL_POST_VIEWS_SEARCH') {
                            $insight->posts_views = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'PHOTOS_VIEWS_MERCHANT') {
                            $insight->photos_views_merchant = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'PHOTOS_VIEWS_CUSTOMERS') {
                            $insight->photos_views_customer = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'PHOTOS_COUNT_MERCHANT') {
                            $insight->photos_count_merchant = $value['totalValue']['value'];
                        }
                        if ($value['metric'] === 'PHOTOS_COUNT_CUSTOMERS') {
                            $insight->photos_count_customer = $value['totalValue']['value'];
                        }
                    }
                    $insight->save();
                });
        }
    }
}
