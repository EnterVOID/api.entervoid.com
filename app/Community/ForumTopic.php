<?php


namespace App\Community;

use App\SluggableModel;

class ForumTopic extends SluggableModel
{
    use Commentable;

    protected $sluggableAttribute = 'topic';

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function topics()
    {
        return $this->hasMany(ForumTopic::class);
    }
}