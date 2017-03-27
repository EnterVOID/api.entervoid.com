<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MatchStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Match[] $matches
 * @mixin \Eloquent
 */
class MatchStatus extends Model
{
    public $timestamps = false;

    /**
     * Get all of the owning "attach" models.
     */
    public function matches()
    {
        return $this->hasMany('App\Match', 'status_id');
    }

}
