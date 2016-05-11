<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CharacterStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Character[] $characters
 * @mixin \Eloquent
 */
class CharacterStatus extends Model
{
    /**
     * Get all of the owning "attach" models.
     */
    public function characters()
    {
        return $this->hasMany('App\Character');
    }

}
