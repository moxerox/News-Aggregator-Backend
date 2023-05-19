<?php

namespace App\Services\NewsSources;

use Illuminate\Support\Facades\Http;

class NewsAPIDataSource extends NewsSource
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

        $full_url .=  'apikey=' . $this->apiKey;

        $response = Http::get($full_url);
//        dd($response->json()['results']);

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

        if (isset($response['results'])) {
            $results = $response['results'];
            $transformedResults = array_map(function ($article) {
                return [
                    'title' => $article['title'],
                    'content' => $article['content'],
                    'pubDate' => $article['pubDate'],
                    'author' => implode(', ',is_array($article['creator'])?$article['creator']:[]),
                    'category' => $article['category'],
                    'image' => $article['image_url'],
                    'source' => 'News API',
                ];
            }, $results);
        }

        return $transformedResults;
    }
}
