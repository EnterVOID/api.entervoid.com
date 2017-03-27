<?php

namespace App\Http\Controllers;

use App\ManagedFile;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Response;

class ManagedFileController extends Controller
{
    const MAX_PAGE_SIZE = 1500;

    public function upload(Request $request)
    {
        return ManagedFile::createFromFile($request->file('fileinput'));
    }

    public function get($id)
    {
        $managedFile = ManagedFile::find($id);
        return (new Response($managedFile->getFile(), 200))->header('Content-Type', $managedFile->mime);
    }

    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = min($request->input('pageSize', 25), static::MAX_PAGE_SIZE);
        return response(ManagedFile::query()->paginate($pageSize, ['*'], 'page', $page));
    }
}

