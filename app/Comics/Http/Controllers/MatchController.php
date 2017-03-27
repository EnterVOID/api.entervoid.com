<?php

namespace App\Comics\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Comics\Match;

class MatchController extends Controller
{
    protected $model = Match::class;

    protected $orderBy = ['title' => 'asc'];
}
