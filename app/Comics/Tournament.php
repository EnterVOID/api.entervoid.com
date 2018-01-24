<?php

namespace App\Comics;

use App\Community\Commentable;
use App\SluggableModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends SluggableModel
{
    use Commentable;
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function getSluggableAttribute()
    {
        return $this->name ?? $this->getKey();
    }

    /**
     * The comics attached to this match.
     */
    public function matches()
    {
        return $this->hasMany(Match::class);
    }
}
