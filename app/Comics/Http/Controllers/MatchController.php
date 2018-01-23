<?php

namespace App\Comics\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Comics\Match;
use Illuminate\Database\Query\JoinClause;
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
		$voting = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			])
			->join('match_statuses', function (JoinClause $join) {
				$join->on('match_statuses.id', '=', 'matches.status_id')
					->where('match_statuses.name', 'Voting');
			})
			->orderBy('due_date', 'desc')
			->get()
		;
		$drawing = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			])
			->join('match_statuses', function (JoinClause $join) {
				$join->on('match_statuses.id', '=', 'matches.status_id')
					->where('match_statuses.name', 'Drawing');
			})
			->orderBy('due_date', 'desc')
			->get()
		;
		$complete = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			])
			->join('match_statuses', function (JoinClause $join) {
				$join->on('match_statuses.id', '=', 'matches.status_id')
					->where('match_statuses.name', 'Complete');
			})
			->orderBy('due_date', 'desc')
			->take(10)
			->get()
		;
		return response([
			'Voting' => $voting,
			'Drawing' => $drawing,
			'Complete' => $complete,
		]);
	}
}
