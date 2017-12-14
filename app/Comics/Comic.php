<?php

namespace App\Comics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Comic
 *
 * @property-read \App\Match $match
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $match_id
 * @property string $title
 * @property string $legacy_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $completed_at
 * @property \Carbon\Carbon $published_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Characters\Character[] $characters
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $creators
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comics\Page[] $pages
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic whereMatchId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic whereLegacyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic whereCompletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Comic whereDeletedAt($value)
 */
class Comic extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'completed_at', 'published_at', 'deleted_at'];
    protected $fillable = [
        'match_id',
        'title',
    ];

    public function characters()
    {
        return $this->belongsToMany('App\Characters\Character');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function match()
    {
        return $this->belongsTo('App\Comics\Match');
    }

    public function pages()
    {
        return $this->hasMany('App\Comics\Page');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
