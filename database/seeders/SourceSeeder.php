<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            [
                'name' => 'Guardian',
                'info' => json_encode([
                    'url' => 'https://content.guardianapis.com/search?show-fields=all&',
                    'api_key' => env('GUARDIAN_API_KEY'),
                ]),
            ],
            [
                'name' => 'News API',
                'info' => json_encode([
                    'url' => 'https://newsdata.io/api/1/news?language=en&',
                    'api_key' => env('NEWS_API_KEY'),
                ]),
            ],
            [
                'name' => 'NewYork Times',
                'info' => json_encode([
                    'url' => 'https://api.nytimes.com/svc/search/v2/articlesearch.json?',
                    'api_key' => env('NYTIMES_API_KEY'),
                ]),
            ],
        ];
        Source::insert($sources);
    }
}
