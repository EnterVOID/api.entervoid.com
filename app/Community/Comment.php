<?php


namespace App\Community;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    use Commentable;

    public function commentable()
    {
        return $this->morphTo();
    }
}