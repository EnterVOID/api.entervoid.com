<?php

namespace App\Http\Controllers;

use App\FileManaged;
use Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class FileManagedController extends Controller {

    public function create() {
        // Upload file, optionally using attacher to generate path dynamically
        $file = Request::file('fileinput');
        $attacher_id = Request::input('attacher_id') ?: null;
        $attacher_type = Request::input('attacher_type') ?: null;
        $path = 'uploads/';
        if ($attacher_id && $attacher_type) {
            $path = $attacher_type . '/' . $attacher_id . '/';
        }
        $filename = $file->getFilename() . '.' . $file->getClientOriginalExtension();
        $destination = $path . $filename;
        Storage::disk('local')->put($destination, File::get($file));
        // Add managed file to database using FileManaged model
        $fileManaged = new FileManaged;
        $fileManaged->mime = $file->getClientMimeType();
        $fileManaged->original_filename = $file->getClientOriginalName();
        $fileManaged->filename = $filename;
        $fileManaged->attacher_id = $attacher_id;
        $fileManaged->attacher_type = $attacher_type;

        $fileManaged->save();

        return $fileManaged;
        
    }

    public function get($id){
        $entry = FileManaged::find($id);
        $path = 'uploads/';
        if ($entry->attacher_id && $entry->attacher_type) {
            $path = $entry->attacher_type . '/' . $entry->attacher_id . '/';
        }
        $file = Storage::disk('local')->get($path . $entry->filename);
 
        return (new Response($file, 200))->header('Content-Type', $entry->mime);
    }
}

