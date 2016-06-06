<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    /**
     * The requested match type.
     */
    public function type()
    {
        return $this->belongsTo('App\MatchType');
    }

    /**
     * The requested participant users in this challenge.
     */
    public function participants()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * The requested participant characters in this challenge.
     */
    public function characters()
    {
        return $this->belongsToMany('App\Character');
    }
}
