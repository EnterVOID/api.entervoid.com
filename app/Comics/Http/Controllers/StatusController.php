<?php

namespace App\Characters\Http\Controllers;

use App\Characters\MatchStatus;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    protected $model = MatchStatus::class;
}
