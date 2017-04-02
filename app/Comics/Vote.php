<?php

namespace App\Comics;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }

    public function voter()
    {
        return $this->belongsTo(User::class);
    }
}
