<?php

namespace App\Comics\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Comics\Comic;

class ComicController extends Controller
{
    protected $model = Comic::class;

    protected $orderBy = ['title' => 'asc'];
}
