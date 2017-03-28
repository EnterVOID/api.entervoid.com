<?php


namespace App\Community\Events;

use App\SluggableModel;
use Illuminate\Queue\SerializesModels;


class SluggableSaving
{
    use SerializesModels;

    public $sluggable;

    /**
     * Create a new event instance.
     *
     * @param  SluggableModel  $sluggable
     * @return void
     */
    public function __construct(SluggableModel $sluggable)
    {
        $this->sluggable = $sluggable;
    }
}