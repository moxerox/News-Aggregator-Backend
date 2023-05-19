<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                    'api_key' => 'bb44a710-7c06-478e-9d98-ea93ce414276',
                ]),
            ],
            [
                'name' => 'News API',
                'info' => json_encode([
                    'url' => 'https://newsdata.io/api/1/news?language=en&',
                    'api_key' => 'pub_222031c1c5feaf8b89a4c2e146465f0946789',
                ]),
            ],
            [
                'name' => 'NewYork Times',
                'info' => json_encode([
                    'url' => 'https://api.nytimes.com/svc/search/v2/articlesearch.json?',
                    'api_key' => 'LjsTdbrhibvL8flqZxS4CY0vG3N6BwTs',
                ]),
            ],
        ];
        Source::insert($sources);
    }
}
