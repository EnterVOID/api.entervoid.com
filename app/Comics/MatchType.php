<?php

namespace App\Comics;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MatchType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Match[] $matches
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $legacy_id
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\MatchType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\MatchType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\MatchType whereLegacyId($value)
 */
class MatchType extends Model
{
    public $timestamps = false;

    /**
     * Get all of the owning "attach" models.
     */
    public function matches()
    {
        return $this->hasMany('App\Comics\Match', 'type_id');
    }

}
