<?php declare(strict_types = 1);

namespace OptimyTest\Models;

/**
 * Comment model class
 */
class Comment extends BaseModel
{
    /**
     * @inheritDoc
     */
    protected array $columns = [
        'id',
        'body',
        'created_at',
        'news_id',
    ];
}