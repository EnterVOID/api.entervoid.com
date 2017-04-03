<?php


namespace App\Community;

use App\SluggableModel;

class Forum extends SluggableModel
{
    protected $sluggableAttribute = 'name';

    public function category()
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function topics()
    {
        return $this->hasMany(ForumTopic::class);
    }
}