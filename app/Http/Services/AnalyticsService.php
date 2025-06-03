<?php

namespace App\Http\Services;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient as ClientBetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;

class AnalyticsService
{
    protected $client;
    protected $propertyId;

    public function __construct()
    {

        $this->client = new ClientBetaAnalyticsDataClient([
            'credentials' => storage_path('app/keys/google-services.json'),
        ]);

        $this->propertyId = '430838609';
    }

    public function getAllVisitors()
    {
        $request = new RunReportRequest([
            'property' => "properties/{$this->propertyId}",
            'date_ranges' => [
                new DateRange([
                    'start_date' => '2025-05-01',
                    'end_date' => 'today',
                ]),
            ],
            'metrics' => [
                new Metric(['name' => 'screenPageViews']), // metrik untuk jumlah views halaman
            ],
            'dimensions' => [
                new Dimension(['name' => 'pageTitle']),  // halaman URL yang diakses
                // atau bisa juga pakai 'pageTitle' kalau mau judul halaman
            ],
        ]);

        $response = $this->client->runReport($request);

        return $response;
    }
}
