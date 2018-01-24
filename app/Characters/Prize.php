<?php

namespace App\Characters;

use App\ManagedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prize extends Model
{
    use SoftDeletes;

    protected $dates = ['awarded_at', 'deleted_at'];

    public function characters()
    {
        return $this->belongsToMany(Character::class);
    }

    public function image()
	{
		return $this->hasOne(ManagedFile::class);
	}
}
