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
				'comics.characters.icon',
				'comics.users',
			])
			->whereHas('status', function ($query) {
				$query->where('name', 'Voting');
			})
			->with(['votes' => function($query) use ($voter_id) {
				$query->where('user_id', $voter_id);
			}])
			->whereRaw('due_date <= CURDATE()')
			->orderBy('due_date', 'desc')
			->orderBy('id')
			->get()
		;
		$drawing = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
				'comics.characters.icon',
				'comics.users',
			])
			->whereHas('status', function ($query) {
				$query->where('name', 'Drawing');
			})
			->whereRaw('due_date <= CURDATE()')
			->orderBy('due_date')
			->orderBy('id')
			->get()
		;
		$complete = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
				'comics.characters.icon',
				'comics.users',
			])
			->whereHas('status', function ($query) {
				$query->where('name', 'Complete');
			})
			->whereRaw('due_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
			->orderBy('due_date', 'desc')
			->orderBy('id', 'desc')
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
