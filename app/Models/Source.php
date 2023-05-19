<?php

namespace App\Models;

use App\Services\NewsSources\GuardianNewsSource;
use App\Services\NewsSources\NewsAPIDataSource;
use App\Services\NewsSources\NewYorkTimesSource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'info',
    ];

    public function getSourceHandler()
    {
        $sourceInfo = json_decode($this->info);

        // Map the source to the corresponding source handler
        switch ($this->name) {
            case 'Guardian':
                return new GuardianNewsSource($sourceInfo->api_key, $sourceInfo->url);
            case 'NewYork Times':
                return new NewYorkTimesSource($sourceInfo->api_key, $sourceInfo->url);
            case 'News API':
                return new NewsAPIDataSource($sourceInfo->api_key, $sourceInfo->url);
//             Add more cases for other sources
            default:
                return null;
        }
    }
}
