<?php

namespace App\Comics\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Comics\Match;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    protected $model = Match::class;

    protected $orderBy = ['title' => 'asc'];

	public function get(Request $request, $id)
	{
		$with = array_merge(
			$request->input('with') ?? [],
			[
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			]
		);

		return response(Match::with($with)->findOrFail($id));
	}
}
