<?php

namespace App\Http\Controllers;

use App\ManagedFile;
use Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Response;

class ManagedFileController extends Controller {

    public function create() {
        return ManagedFile::createFromFile(Request::file('fileinput'));
    }

    public function get($id){
        $managedFile = ManagedFile::find($id);
        return (new Response($managedFile->getFile(), 200))->header('Content-Type', $managedFile->mime);
    }
}

