<?php

namespace App\Comics\Http\Controllers;

use App\Comics\Page;
use App\Http\Controllers\Controller;
use App\Comics\Comic;

class ComicController extends Controller
{
    protected $model = Comic::class;

    protected $orderBy = ['title' => 'asc'];

    public function getPage($match_id, $side, $page_number)
	{
		return response(
			Page::with([
				'managedFile',
				'thumbnail.managedFile',
				'comic.users',
				'comic.match',
			])
				->whereHas('comic', function($query) use ($side, $match_id) {
					$query->where('side', $side);
					$query->where('match_id', $match_id);
				})
				->where('page_number', $page_number)
				->firstOrFail()
		);
	}
}
