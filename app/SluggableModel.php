<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SluggableModel extends Model
{
    protected $sluggableAttribute;

    public function getSluggableAttribute()
    {
        return $this->getAttribute($this->sluggableAttribute);
    }
}
