<?php

namespace App\Http\Controllers;

use App\Character;
use App\CharacterStatus;
use App\CharacterType;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    protected $model = Character::class;

    public function get($id, $with = null)
    {
        if ($with === 'artwork') {
            $with = [
                'icon',
                'designSheet',
                'supplementaryArt',
                'intro',
            ];
        }
        return parent::get($id, $with);
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
