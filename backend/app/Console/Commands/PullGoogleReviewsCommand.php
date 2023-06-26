<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Franchise;
use App\Service\FranchiseService;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class PullGoogleReviewsCommand extends Command
{
    private const URL = 'https://api.apify.com/v2/datasets/QwKoexRSaxEHFSnZf/items?token=apify_api_14I9qN3xb6NULHms0P7qIQsIzgbK460QpIZw';

    protected $signature = 'app:pull-google-reviews-command';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // TODO: Handle adding company from UI
        $company = Company::find(1);
        if (!$company) {
            $company = new Company([
                'name' => 'Planeta Sport',
                'location' => 'Serbia'
            ]);
            $company->save();
        }

        $client = new Client();
        $response = $client->request('GET', self::URL);

        if ($response->getStatusCode() > 200) {
            $this->error('Failed to retrieve Google reviews.');
            return;
        }

        $data = json_decode($response->getBody(), true);
        $franchiseService = app(FranchiseService::class);

        foreach ($data as $franchise) {
            $franchiseModel = Franchise::firstOrNew(['place_id' => $franchise['cid']]);
            $franchiseModel->setPlaceIdAttribute($franchise['cid']);
            $franchiseModel->name = $franchise['title'] . ' ' . $franchise['city']  . ' ' . $franchise['street'];
            $franchiseModel->address = $franchise['address'];
            $franchiseModel->phone = $franchise['phone'] ?? '';
            $franchiseModel->rating = $franchise['totalScore'];
            $franchiseModel->reviews = $franchise['reviewsCount'];
            $franchiseModel->reviewsPerMonth = $franchiseService->calculateLastMonthReviews($franchise['reviews']);
            $franchiseModel->score = $franchiseService->calculateScore($franchiseModel);
            $franchiseModel->company()->associate($company);
            $franchiseModel->save();
        }

        $this->info('Google reviews for Planeta Sport stores in Serbia have been retrieved.');
    }
}
