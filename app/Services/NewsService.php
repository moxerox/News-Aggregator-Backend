<?php

namespace App\Services;

use App\Models\Source;
use App\Services\NewsSources\GuardianNewsSource;
use App\Services\NewsSources\NewsAPIDataSource;
use App\Services\NewsSources\NewYorkTimesSource;

class NewsService
{
    public function fetchNewsFromSource(Source $source, array $searchParams = [])
    {
        $sourceHandler = $source->getSourceHandler();

        if ($sourceHandler) {
            return $sourceHandler->fetchNews($searchParams);
        }

        return null;
    }

    public function fetchAllNews(array $searchParams = [])
    {
        $allNews = [];

        $sources = Source::all();
        foreach ($sources as $source) {
            $news = $this->fetchNewsFromSource($source, $searchParams);
            if ($news) {
                $allNews = array_merge($allNews, $news);
            }
        }

        return $allNews;
    }
}
