<?php

namespace App\Http\Controllers;

use App\Match;
use App\MatchStatus;
use App\MatchType;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    const MAX_PAGE_SIZE = 1500;

    public function get($id)
    {
        return response(Match::findOrFail($id));
    }

    public function getMany(Request $request)
    {
        $query = Match::query();
        $order = $request->input('order', ['title' => 'asc']);
        $this->order($order, $query);
        return response($this->paginate($request, $query));
    }

    public function create(Request $request)
    {
        return Match::create($request->json()->all());
    }

    public function getType($id)
    {
        return MatchType::findOrFail($id);
    }

    public function getTypes(Request $request)
    {
        $query = MatchType::query();
        $order = $request->input('order', ['name' => 'asc']);
        $this->order($order, $query);
        return response($this->paginate($request, $query));
    }

    public function createType(Request $request)
    {
        return MatchType::create($request->json()->all());
    }

    public function getStatus($id)
    {
        return MatchStatus::findOrFail($id);
    }

    public function getStatuses(Request $request)
    {
        $query = MatchStatus::query();
        $order = $request->input('order', ['name' => 'asc']);
        $this->order($order, $query);
        return response($this->paginate($request, $query));
    }

    public function createStatus(Request $request)
    {
        return MatchStatus::create($request->json()->all());
    }
}
