<?php

namespace App\Comics;

use Illuminate\Database\Eloquent\Model;

class PlaylistItem extends Model
{
    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    public function playlisted()
	{
		return $this->morphTo();
	}
}
