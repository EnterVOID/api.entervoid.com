<?php

namespace App\Comics;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Comics\Challenge
 *
 * @property integer $id
 * @property string $title
 * @property integer $length
 * @property integer $page_limit
 * @property string $message
 * @property integer $type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Comics\MatchType $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $participants
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Characters\Character[] $characters
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Challenge whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Challenge whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Challenge whereLength($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Challenge wherePageLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Challenge whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Challenge whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Challenge whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Challenge whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Challenge extends Model
{
    /**
     * The requested match type.
     */
    public function type()
    {
        return $this->belongsTo('App\Comics\MatchType');
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
        return $this->belongsToMany('App\Characters\Character');
    }
}
