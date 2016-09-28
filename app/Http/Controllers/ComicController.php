<?php

namespace App\Http\Controllers;

use App\Character;
use App\Comic;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    const MAX_PAGE_SIZE = 1500;

    public function get($id)
    {
        return response(Comic::with(['pages', 'characters', 'creators'])->findOrFail($id));
    }

    public function getMany(Request $request)
    {
        $query = Comic::with(['pages', 'characters', 'creators']);
        $order = $request->input('order', ['title' => 'asc']);
        $this->order($order, $query);
        return response($this->paginate($request, $query));
    }

    public function create(Request $request)
    {
        $data = $request->json()->all();
        $comic = Comic::create($data);
        $comic->characters()->attach($data['characters']);
        $comic->creators()->attach($data['creators']);
        $comic->load(['characters', 'creators']);
        return response($comic);
    }
}
