<?php

namespace App\Comics\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Characters\Character;
use App\Comics\Comic;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ComicController extends Controller
{
    protected $model = Comic::class;

    protected $orderBy = ['title' => 'asc'];

//    const MAX_PAGE_SIZE = 1500;
//
//    public function get($id)
//    {
//        return response(Comic::with(['pages', 'characters', 'creators'])->findOrFail($id));
//    }
//
//    public function getMany(Request $request)
//    {
//        \DB::enableQueryLog();
//        try {
//            $query = Comic::with(['pages', 'characters', 'creators']);
//            $order = $request->input('order', ['title' => 'asc']);
//            $this->order($order, $query);
//            return response($this->paginate($request, $query));
//        } catch (InvalidArgumentException $e) {
//            dd(\DB::getQueryLog());
//        }
//    }
//
//    public function create(Request $request)
//    {
//        $data = $request->json()->all();
//        $comic = Comic::create($data);
//        $comic->characters()->attach($data['characters']);
//        $comic->creators()->attach($data['creators']);
//        $comic->load(['characters', 'creators']);
//        return response($comic);
//    }
}
