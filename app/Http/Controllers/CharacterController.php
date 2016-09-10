<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    const MAX_PAGE_SIZE = 1500;

    public function get($id, $with = null)
    {
        if ($with) {
            return response(Character::with($with)->findOrFail($id));
        }
        return response(Character::findOrFail($id));
    }

    public function getMany(Request $request)
    {
        $query = Character::query();
        $this->order($request, $query);
        return response($this->paginate($request, $query));
    }
}
