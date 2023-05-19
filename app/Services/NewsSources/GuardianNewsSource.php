<?php

namespace App\Services\NewsSources;

use Illuminate\Support\Facades\Http;

class GuardianNewsSource extends NewsSource
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

        if (isset($response['response']['results'])) {
            $results = $response['response']['results'];
            $transformedResults = array_map(function ($article) {
                return [
                    'title' => $article['fields']['headline']??'',
                    'content' => $article['fields']['bodyText']??'',
                    'pubDate' => $article['fields']['firstPublicationDate']??'',
                    'author' => $article['fields']['byline']??'',
                    'category' => [$article['sectionName']??null],
                    'image' => $article['fields']['thumbnail']??'',
                    'source' => 'The Guardian',
                ];
            }, $results);
        }
        return $transformedResults;
    }
}
