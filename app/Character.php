<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Character
 *
 * @property integer $id
 * @property string $name
 * @property string $gender
 * @property string $height
 * @property string $weight
 * @property string $bio
 * @property \App\CharacterType $type
 * @property \App\CharacterStatus $status
 * @property string $icon_id
 * @property string $design_sheet_id
 * @property integer $intro_id
 * @property string $intro_id_legacy
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $creators
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comic[] $comics
 * @property-read \App\ManagedFile $icon
 * @property-read \App\ManagedFile $design_sheet
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ManagedFile[] $supplementary_art
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereBio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereIconId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereDesignSheetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereIntroId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereIntroIdLegacy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Character extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gender',
        'height',
        'weight',
        'bio',
        'type_id',
        'status_id',
        'icon_id',
        'design_sheet_id',
        'intro_id',
    ];

    protected $with = [
        'type',
        'status',
        'icon',
    ];

    /**
     * Get the character icon.
     */
    public function type()
    {
        return $this->belongsTo('App\CharacterType');
    }

    /**
     * Get the character icon.
     */
    public function status()
    {
        return $this->belongsTo('App\CharacterStatus');
    }

    /**
     * The users ("creators") attached to this character.
     */
    public function creators()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * The comics attached to this character.
     */
    public function comics()
    {
        return $this->belongsToMany('App\Comic');
    }

    /**
     * Get the character icon.
     * Fun Fact: This works opposite of how morphOne would normally work, because it uses
     * characters.icon_id = files_managed.id instead of files_managed.attacher_id = characters.id
     */
    public function icon()
    {
        return $this->morphOne('App\ManagedFile', 'attacher', null, 'id', 'icon_id');
    }

    /**
     * Get the character icon.
     */
    public function designSheet()
    {
        return $this->morphOne('App\ManagedFile', 'attacher', null, null, 'design_sheet_id');
    }

    public function intro()
    {
        return $this->belongsTo('App\Comic');
    }

    /**
     * Get all of the character's supplementary art.
     */
    public function supplementaryArt()
    {
        return $this->morphMany('App\ManagedFile', 'attacher');
    }
}
