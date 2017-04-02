<?php

namespace App\Comics;

use App\Community\Commentable;
use App\SluggableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Match
 *
 * @property-read \App\Comics\MatchType $type
 * @property-read \App\Comics\MatchStatus $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comics\Comic[] $comics
 * @mixin \Eloquent
 * @property integer $id
 * @property string $title
 * @property integer $type_id
 * @property integer $length
 * @property integer $page_limit
 * @property \Carbon\Carbon $due_date
 * @property integer $status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereLength($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match wherePageLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereDueDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comics\Match whereDeletedAt($value)
 */
class Match extends SluggableModel
{
    use Commentable;
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
    
    public function getSluggableAttribute()
    {
        return $this->title ?? $this->getKey();
    }

    /**
     * Get the character icon.
     */
    public function type()
    {
        return $this->belongsTo('App\Comics\MatchType');
    }

    /**
     * Get the character icon.
     */
    public function status()
    {
        return $this->belongsTo('App\Comics\MatchStatus');
    }

    /**
     * The comics attached to this match.
     */
    public function comics()
    {
        return $this->belongsToMany('App\Comics\Comic');
    }

    public function votes()
    {
        return $this->hasManyThrough(Vote::class, Comic::class);
    }
}
