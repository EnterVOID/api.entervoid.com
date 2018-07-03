<?php

namespace App\Comics;

use App\Characters\Character;
use App\Community\Commentable;
use App\SluggableModel;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

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

    protected $with = [
        'type',
        'status',
        'comics',
    ];

    protected $appends = [
    	'auto_title',
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

	public function characters()
	{
		return $this->hasManyThrough(Character::class, Comic::class);
	}

    /**
     * The comics attached to this match.
     */
    public function comics()
    {
        return $this->hasMany('App\Comics\Comic');
    }

    public function playlistItem()
	{
		return $this->morphOne(PlaylistItem::class, 'playlisted');
	}

	public function users()
	{
		return $this->hasManyThrough(User::class, Comic::class);
	}

    public function votes()
    {
        return $this->hasManyThrough(Vote::class, Comic::class);
    }

    public function getAutoTitleAttribute()
	{
		$titleArray = [];
		foreach ($this->comics as $comic) {
			$titleArray[$comic->id] = $comic->characters->pluck('name')->isEmpty()
				? $comic->users->pluck('name')->isEmpty()
					? collect('???')
					: $comic->users->pluck('name')->all()
				: $comic->characters->pluck('name')->all();
		}
		return implode(' vs. ', map($titleArray, function($names) {
			$names = collect($names);
			if (count($names) > 1) {
				$names->push('and ' . $names->pop());
			}
			return $names->implode(', ');
		}));
	}
}
