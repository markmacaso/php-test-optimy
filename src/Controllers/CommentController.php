<?php declare(strict_types = 1);

namespace OptimyTest\Controllers;

use OptimyTest\Models\Comment;
use OptimyTest\Traits\CommentExistTrait;
use OptimyTest\Traits\NewsExistTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class that handle news related requests
 */
class CommentController extends BaseController
{
    use CommentExistTrait, NewsExistTrait;

    /**
     * List all comments of news
     *
     * @param  Request $request
     * @return string
     */
    public function index(Request $request)
    {
        $news = $this->verifyNewsExistById($request);
        $comments = $news->getComments();
        return $this->view('comments.html', ['comments' => $comments]);
    }

    /**
     * Get a comment
     *
     * @param  Request $request
     * @return string
     */
    public function comment(Request $request)
    {
        $comment = $this->verifyCommentExistById($request);
        return $this->view('comment.html', ['comment' => $comment]);
    }

    /**
     * Add a comment
     *
     * @param  Request $request
     * @return string
     */
    public function add(Request $request)
    {
        $news = $this->verifyNewsExistById($request);
        $body = $request->get('body');

        if (!$body) {
            throw new \Exception('Missing news body parameter');
        }

        $news = Comment::create([
            'news_id' => $news->id,
            'body' => $body,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->text('Successfully added comment');
    }

    /**
     * Delete a comment
     *
     * @param  Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $comment = $this->verifyCommentExistById($request);
        $comment->delete();
        return $this->text('Successfully deleted comment');
    }
}