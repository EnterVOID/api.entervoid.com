<?php

namespace App\Comics\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Comics\Playlist;

class PlaylistController extends Controller
{
    protected $model = Playlist::class;

    protected $orderBy = ['order' => 'asc'];
}
