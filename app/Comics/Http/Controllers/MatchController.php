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
		$voter_id = $request->input('voter_id');
		$voting = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			])
			->whereHas('status', function ($query) {
				$query->where('name', 'Voting');
			})
			->with(['votes' => function($query) use ($voter_id) {
				$query->where('user_id', $voter_id);
			}])
			->orderBy('due_date', 'desc')
			->get()
		;
		$drawing = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			])
			->whereHas('status', function ($query) {
				$query->where('name', 'Drawing');
			})
			->orderBy('due_date', 'desc')
			->get()
		;
		$complete = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			])
			->whereHas('status', function ($query) {
				$query->where('name', 'Complete');
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
