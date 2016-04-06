<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function get(Request $request, $id)
    {
        return Character::find($id);
    }
}
