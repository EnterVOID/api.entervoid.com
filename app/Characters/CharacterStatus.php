<?php

namespace App\Characters;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CharacterStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Character[] $characters
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $legacy_id
 * @method static \Illuminate\Database\Query\Builder|\App\Characters\CharacterStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Characters\CharacterStatus whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Characters\CharacterStatus whereLegacyId($value)
 */
class CharacterStatus extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'legacy_id',
    ];

    /**
     * Get all of the owning "attach" models.
     */
    public function characters()
    {
        return $this->hasMany('App\Characters\Character', 'status_id');
    }

}
