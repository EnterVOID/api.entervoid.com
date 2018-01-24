<?php

namespace App\Comics;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    public function items()
    {
        return $this->hasMany(PlaylistItem::class);
    }
}
