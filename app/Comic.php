<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Comic
 *
 * @property-read \App\Match $match
 * @mixin \Eloquent
 */
class Comic extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'completed_at', 'published_at', 'deleted_at'];
    protected $with = ['match'];
    protected $fillable = [
        'match_id',
        'title',
    ];

    public function characters()
    {
        return $this->belongsToMany('App\Character');
    }

    public function creators()
    {
        return $this->belongsToMany('App\User');
    }

    public function match()
    {
        return $this->belongsTo('App\Match');
    }

    public function pages()
    {
        return $this->hasMany('App\ComicPage');
    }
}
