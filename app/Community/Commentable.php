<?php

namespace App\Community;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Commentable
 * @package App\Community
 * @property bool comments_allowed
 */
trait Commentable
{
    /**
     * @return MorphMany|null
     */
    public function comments()
    {
        if ($this->comments_allowed === false) {
            return null;
        }
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @param Comment $comment
     * @param Comment|null $parentComment
     */
    public function attachComment(Comment $comment, Comment $parentComment = null)
    {
        if ($this->comments_allowed === false) {
            throw new \LogicException('Cannot attach comment to node: commenting not allowed on this object.');
        }
        if ($parentComment) {
            $comment->parentComment()->associate($parentComment);
        }
        $this->comments()->save($comment);
    }
}