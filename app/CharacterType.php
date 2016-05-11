<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CharacterType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Character[] $characters
 * @mixin \Eloquent
 */
class CharacterType extends Model
{
    /**
     * Get all of the owning "attach" models.
     */
    public function characters()
    {
        return $this->hasMany('App\Character');
    }

}
