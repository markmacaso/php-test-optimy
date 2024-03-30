<?php declare(strict_types = 1);

namespace OptimyTest\Controllers;

use OptimyTest\Models\News;
use OptimyTest\Traits\NewsExistTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class that handle news related requests
 */
class NewsController extends BaseController
{
    use NewsExistTrait;

    /**
     * List all news and comments
     *
     * @param  Request $request
     * @return string
     */
    public function index(Request $request)
    {
        $news = News::list()->get();
        return $this->view('index.html', ['news' => $news]);
    }

    /**
     * Get a news
     *
     * @param  Request $request
     * @return string
     */
    public function news(Request $request)
    {
        $news = $this->verifyNewsExistById($request);
        return $this->view('news.html', ['news' => $news]);
    }

    /**
     * Add a news
     *
     * @param  Request $request
     * @return string
     */
    public function add(Request $request)
    {
        $title = $request->get('title');
        $body = $request->get('body');

        if (!$title) {
            throw new \Exception('Missing news title parameter');
        }
        if (!$body) {
            throw new \Exception('Missing news body parameter');
        }

        $news = News::create([
            'title' => $title,
            'body' => $body,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->text('Successfully added news');
    }

    /**
     * Delete a news
     *
     * @param  Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $news = $this->verifyNewsExistById($request);
        $news->delete();
        return $this->text('Successfully deleted news');
    }
}