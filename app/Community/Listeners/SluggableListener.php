<?php

namespace App\Community\Listeners;

use App\Community\Events\SluggableSaving;

class GenerateSlug
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SluggableSaving  $event
     * @return void
     */
    public function handle(SluggableSaving $event)
    {
        if (empty($event->sluggable->slug)) {
            $event->sluggable->slug = str_slug($event->sluggable->getSluggableAttribute());
        }
    }
}