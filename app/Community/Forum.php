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

	public function parent()
	{
		return $this->belongsTo(Forum::class, 'parent_forum_id');
	}

	public function children()
	{
		return $this->hasMany(Forum::class, 'parent_forum_id');
	}

    public function topics()
    {
        return $this->hasMany(ForumTopic::class);
    }
}