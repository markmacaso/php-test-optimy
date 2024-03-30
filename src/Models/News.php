<?php declare(strict_types = 1);

namespace OptimyTest\Models;

use OptimyTest\Database\Database;

/**
 * News model class
 */
class News extends BaseModel
{
    /**
     * @inheritDoc
     */
    protected array $columns = [
        'id',
        'title',
        'body',
        'created_at'
    ];

    /**
     * Get comments of this news
     *
     * @return array
     */
    public function getComments() : array
    {
        return Comment::list()->where('news_id', '=', $this->id)->get();
    }

    /**
     * @inheritDoc
     */
    public function delete()
    {
        // Delete the comments for this news
        $comment = new Comment();
        $database = Database::getInstance();
        $database->delete(
            $comment->getTableName(),
            [
                [
                    'news_id',
                    '=',
                    $this->id
                ]
            ]
        );

        parent::delete();
    }
}