<?php
namespace App\Comics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Comics\Thumbnail
 *
 * @property-read \App\Comics\Page $page
 * @property-read \App\ManagedFile $managedFile
 * @mixin \Eloquent
 */
class Thumbnail extends Model
{
    use SoftDeletes;

    protected $with = ['managedFile'];
    protected $table = 'comic_page_thumbnails';

    public function page()
    {
        return $this->belongsTo('App\Comics\Page');
    }

    public function managedFile()
    {
        return $this->belongsTo('App\ManagedFile');
    }
}