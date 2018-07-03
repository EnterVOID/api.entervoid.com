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
		$voter_id = $request->input('voter_id');
		$with = array_merge(
			$request->input('with') ?? [],
			[
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
				'comics.characters.icon',
				'comics.users',
			]
		);

		return response(
			Match::with($with)
				->withCount(['votes' => function($query) use ($voter_id) {
					$query->where('user_id', $voter_id);
				}])
				->with(['comics' => function($query) {
					$query->leftJoin('votes', 'votes.comic_id', 'comics.id')
						->selectRaw('
							comics.*,
							COUNT(votes.quality) AS votes,
							SUM(votes.quality) AS quality,
							SUM(votes.creativity) AS creativity,
							SUM(votes.entertainment) AS entertainment
						')
						->whereNull('votes.deleted_at')
						->where('votes.warning_issued', 0)
						->groupBy('comics.id')
					;
				}])
				->findOrFail($id)
		);
	}

	public function home(Request $request)
	{
		$voter_id = $request->input('voter_id');
		// \DB::enableQueryLog();
		$voting = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
				'comics.characters.icon',
				'comics.users',
			])
			->withCount('comments')
			->withCount(['votes' => function($query) use ($voter_id) {
				$query->where('user_id', $voter_id);
			}])
			->with(['comics' => function($query) {
				$query->leftJoin('votes', 'votes.comic_id', 'comics.id')
					->selectRaw('
						comics.*,
						COUNT(votes.quality) AS votes,
						SUM(votes.quality) AS quality,
						SUM(votes.creativity) AS creativity,
						SUM(votes.entertainment) AS entertainment
					')
					->whereNull('votes.deleted_at')
					->where('votes.warning_issued', 0)
					->groupBy('comics.id')
				;
			}])
			->whereHas('status', function ($query) {
				$query->where('name', 'Voting');
			})
			->whereRaw('due_date >= CURDATE()')
			->orderBy('due_date', 'desc')
			->orderBy('id')
			->get()
		;
		// var_dump(\DB::getQueryLog());
		// die();
		$drawing = Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
				'comics.characters.icon',
				'comics.users',
			])
			->withCount('comments')
			->with(['comics' => function($query) {
				$query->leftJoin('votes', 'votes.comic_id', 'comics.id')
					->selectRaw('
						comics.*,
						COUNT(votes.quality) AS votes,
						SUM(votes.quality) AS quality,
						SUM(votes.creativity) AS creativity,
						SUM(votes.entertainment) AS entertainment
					')
					->whereNull('votes.deleted_at')
					->groupBy('comics.id')
				;
			}])
			->whereHas('status', function ($query) {
				$query->where('name', 'Drawing');
			})
			->whereRaw('due_date >= CURDATE()')
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
			->withCount('comments')
			->with(['comics' => function($query) {
				$query->leftJoin('votes', 'votes.comic_id', 'comics.id')
					->selectRaw('
						comics.*,
						COUNT(votes.quality) AS votes,
						SUM(votes.quality) AS quality,
						SUM(votes.creativity) AS creativity,
						SUM(votes.entertainment) AS entertainment
					')
					->whereNull('votes.deleted_at')
					->groupBy('comics.id')
				;
			}])
			->whereHas('status', function ($query) {
				$query->where('name', 'Complete');
			})
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

	public function home(Request $request, $id)
	{
		return response(
			Match::with([
				'comics.pages.managedFile',
				'comics.pages.thumbnail.managedFile',
			])
			->groupBy(['status'])
			->findOrFail($id)
		);
	}
}
