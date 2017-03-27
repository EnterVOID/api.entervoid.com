<?php

namespace App\Comics;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MatchStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Match[] $matches
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $legacy_id
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\MatchStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\MatchStatus whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\MatchStatus whereLegacyId($value)
 */
class MatchStatus extends Model
{
    public $timestamps = false;

    /**
     * Get all of the owning "attach" models.
     */
    public function matches()
    {
        return $this->hasMany('App\Comics\Match', 'status_id');
    }

}
