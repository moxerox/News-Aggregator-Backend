<?php

namespace App\Services\NewsSources;

use Illuminate\Support\Facades\Http;

class NewYorkTimesSource extends NewsSource
{
    public function __construct($apiKey, $url)
    {
        parent::__construct($apiKey, $url);
    }

    public function fetchNews($searchParams=null)
    {
        $full_url = $this->url;
        if(isset($searchParams['q']))
            $full_url .= 'q=' . $searchParams['q'] . '&';

        $full_url .=  'api-key=' . $this->apiKey;

        $response = Http::get($full_url);

        if ($response->successful()) {
            $responseData = $response->json();

            // Transform the API response data
            return $this->transformApiResponse($responseData);
        }

        return null;
    }

    private function transformApiResponse(array $response)
    {
        $transformedResults = [];

        if (isset($response['response']['docs'])) {
            $results = $response['response']['docs'];
            $transformedResults = array_map(function ($article) {
                return [
                    'title' => $article['headline']['main'],
                    'content' => $article['abstract']??'',
                    'pubDate' => $article['pub_date']??'',
                    'author' =>$article['byline']['original']??'',
                    'category' => $article['section_name'],
                    'image' => 'https://www.nytimes.com/'.$article['multimedia'][0]['url']??'',
                    'source' => 'NewYork Times',
                ];
            }, $results);
        }
        return $transformedResults;
    }
}
