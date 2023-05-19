<?php

namespace App\Services\NewsSources;

abstract class NewsSource
{
    protected $apiKey;
    protected $url;

    public function __construct($apiKey, $url)
    {
        $this->apiKey = $apiKey;
        $this->url = $url;
    }

    abstract public function fetchNews();
}
