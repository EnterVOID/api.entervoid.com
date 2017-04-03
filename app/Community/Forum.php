<?php


namespace App\Community;

use App\SluggableModel;

class ForumCategory extends SluggableModel
{
    protected $sluggableAttribute = 'name';

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }
}