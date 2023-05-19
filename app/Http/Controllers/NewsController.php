<?php

namespace App\Http\Controllers;

use App\Models\Source;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function sortArticles($news, $direction){
        // Sorting the news articles
        return collect($news)->sortBy(callback: 'pubDate', descending: $direction === 'desc' )->values();
    }

    public function index(Request $request)
    {
//        dd($request);
        $source = $request['source']; // Get requested sources from the request
        $searchParams = $request['search_params'] ?? []; // Get search parameters from the request
        $sortDirection = $searchParams['sort']??'desc';

        $allNews = [];

        if(isset($request['source'])){
            $source = Source::find($source);
            $news = $this->newsService->fetchNewsFromSource($source, $searchParams);

            return response()->json([
                'news'=>$this->sortArticles($news, $sortDirection),
                'search_params'=>$searchParams,
                'sources' => $source
            ]);
        }

        $sources = Source::all();

        foreach ($sources as $source) {

            $source = Source::find($source->id??$source);

            $news = $this->newsService->fetchNewsFromSource($source, $searchParams);

            if ($news) {
                    $allNews = array_merge($allNews, $news);
            }
        }

        if (isset($searchParams['author'])){
            $keyword = $searchParams['author'];
            $allNews = array_filter($allNews, function($item) use ($keyword) {
                return str_contains($item['author'], $keyword);
            });
        }
        if (isset($searchParams['category'])){
            $keyword = $searchParams['category'];
            $allNews = array_filter($allNews, function($item) use ($keyword) {
                return str_contains($item['category'], $keyword) || in_array($keyword,$item['category']);
            });
        }

        // Process or return the aggregated news data
        return response()->json([
            'news'=>$this->sortArticles($allNews, $sortDirection),
            'search_params'=>$searchParams,
            'sources' => $sources
        ]);
    }
}
