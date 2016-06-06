<?php

namespace App\Http\Controllers;

use App\Character;
use App\CharacterType;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function get(Request $request, $id)
    {
        return Character::find($id);
    }

    public function getTypeFromLegacy(Request $request, $legacy_id)
    {
        return CharacterType::where('legacy_id', '=', $legacy_id)->get();
    }
}
