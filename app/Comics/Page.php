<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ComicPage extends Model
{
    use SoftDeletes;

    protected $with = ['managedFile'];

    public function comic()
    {
        return $this->belongsTo('App\Comic');
    }

    public function thumbnail()
    {
        return $this->hasOne('App\ComicPageThumbnail');
    }

    public function managedFile()
    {
        return $this->belongsTo('App\ManagedFile');
    }
}