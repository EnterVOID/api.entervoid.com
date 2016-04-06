<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'status',
    ];

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
     */
    public function icon()
    {
        return $this->hasOne('App\FileManaged', null, 'icon_id');
    }

    /**
     * Get the character icon.
     */
    public function design_sheet()
    {
        return $this->hasOne('App\FileManaged', null, 'design_sheet_id');
    }

    /**
     * Get all of the character's supplementary art.
     */
    public function supplementary_art()
    {
        return $this->morphMany('App\FileManaged', 'attacher');
    }
}
