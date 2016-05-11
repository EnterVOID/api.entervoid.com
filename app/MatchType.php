<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MatchType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Match[] $matches
 * @mixin \Eloquent
 */
class MatchType extends Model
{
    /**
     * Get all of the owning "attach" models.
     */
    public function matches()
    {
        return $this->hasMany('App\Match');
    }

}
