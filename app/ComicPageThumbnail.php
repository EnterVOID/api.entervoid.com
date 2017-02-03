<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ComicPageThumbnail extends Model
{
    use SoftDeletes;

    protected $with = ['managedFile'];

    public function page()
    {
        return $this->belongsTo('App\ComicPage');
    }

    public function managedFile()
    {
        return $this->belongsTo('App\ManagedFile');
    }
}