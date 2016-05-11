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
    /**
     * Get all of the owning "attach" models.
     */
    public function matches()
    {
        return $this->hasMany('App\Match');
    }

}
