<?php

namespace App\Community;

use App\Community\Events\SluggableSaving;
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
    protected $events = [
        'saving' => SluggableSaving::class,
    ];
    protected $sluggableAttribute = 'title';
}
