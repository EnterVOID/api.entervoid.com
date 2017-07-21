<?php

namespace App\Community;

use App\SluggableModel;

class Webpage extends SluggableModel
{
    use Commentable;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'published',
        'created_by',
        'updated_by',
    ];

    protected $sluggableAttribute = 'title';
}
