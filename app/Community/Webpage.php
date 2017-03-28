<?php

namespace App\Community;

use App\Community\Events\SluggableSaving;
use App\SluggableModel;

class Webpage extends SluggableModel
{
    use Commentable;

    protected $events = [
        'saving' => SluggableSaving::class,
    ];
    protected $sluggableAttribute = 'title';
}
