<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Match
 *
 * @property-read \App\MatchType $type
 * @property-read \App\MatchStatus $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comic[] $comics
 * @mixin \Eloquent
 */
class Match extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'due_date', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'status',
    ];

    /**
     * Get the character icon.
     */
    public function type()
    {
        return $this->belongsTo('App\MatchType');
    }

    /**
     * Get the character icon.
     */
    public function status()
    {
        return $this->belongsTo('App\MatchStatus');
    }

    /**
     * The comics attached to this match.
     */
    public function comics()
    {
        return $this->belongsToMany('App\Comic');
    }
}
