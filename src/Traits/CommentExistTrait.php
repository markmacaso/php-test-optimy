<?php declare(strict_types = 1);

namespace OptimyTest\Traits;

use OptimyTest\Models\Comment;
use Symfony\Component\HttpFoundation\Request;

/**
 * A trait that checks if a news exist
 */
trait CommentExistTrait
{
    /**
     * Check if the comment exist by ID
     *
     * @param  Request $request
     * @return Comment|null
     */
    public function verifyCommentExistById(Request $request) : Comment|null
    {
        $commentId = $request->get('comment_id');

        if (!$commentId) {
            throw new \Exception('Missing comment_id parameter');
        }

        $commentId = (int)$commentId;
        $comment = Comment::find($commentId);

        if (!$comment) {
            throw new \Exception("comment_id {$commentId} does not exist");
        }

        return $comment;
    }
}