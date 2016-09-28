<?php

namespace App\Http\Controllers;

use App\Character;
use App\CharacterStatus;
use App\CharacterType;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    const MAX_PAGE_SIZE = 1500;

    public function get($id, $with = null)
    {
        if ($with === 'artwork') {
            return response(Character::with([
                'icon',
                'designSheet',
                'supplementaryArt',
                'intro',
            ])->findOrFail($id));
        }
        if ($with) {
            return response(Character::with($with)->findOrFail($id));
        }
        return response(Character::findOrFail($id));
    }

    public function create(Request $request)
    {
        return Character::create($request->json()->all());
    }

    public function getMany(Request $request)
    {
        $query = Character::query();
        $order = $request->input('order', ['name' => 'asc']);
        $this->order($order, $query);
        return response($this->paginate($request, $query));
    }

    public function getType($id)
    {
        return CharacterType::findOrFail($id);
    }

    public function getTypes(Request $request)
    {
        $query = CharacterType::query();
        $order = $request->input('order', ['name' => 'asc']);
        $this->order($order, $query);
        return response($this->paginate($request, $query));
    }

    public function createType(Request $request)
    {
        return CharacterType::create($request->json()->all());
    }

    public function getStatus($id)
    {
        return CharacterStatus::findOrFail($id);
    }

    public function getStatuses(Request $request)
    {
        $query = CharacterStatus::query();
        $order = $request->input('order', ['name' => 'asc']);
        $this->order($order, $query);
        return response($this->paginate($request, $query));
    }

    public function createStatus(Request $request)
    {
        return CharacterStatus::create($request->json()->all());
    }
}
