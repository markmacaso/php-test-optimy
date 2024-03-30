<?php declare(strict_types = 1);

namespace OptimyTest\Traits;

use OptimyTest\Models\News;
use Symfony\Component\HttpFoundation\Request;

/**
 * A trait that checks if a news exist
 */
trait NewsExistTrait
{
    /**
     * Check if the news exist by ID
     *
     * @param  Request $request
     * @return News|null
     */
    public function verifyNewsExistById(Request $request) : News|null
    {
        $newsId = $request->get('news_id');

        if (!$newsId) {
            throw new \Exception('Missing news_id parameter');
        }

        $newsId = (int)$newsId;
        $news = News::find($newsId);

        if (!$news) {
            throw new \Exception("news_id {$newsId} does not exist");
        }

        return $news;
    }
}