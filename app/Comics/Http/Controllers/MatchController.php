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

	public function home(Request $request)
	{
		return response(
			Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			])
			->join('match_statuses', function ($join) {
				$join->on('match_statuses.id', '=', 'matches.status_id')
				->where('match_statuses.name', [
					'Drawing',
					'Voting',
					'Complete',
				]);
			})
			->groupBy(['status_id'])
			->orderBy(['due_date'])
			->get()
		);
	}
}
