<?php
namespace App\Comics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Comics\Page
 *
 * @property-read \App\Comics\Comic $comic
 * @property-read \App\Comics\Thumbnail $thumbnail
 * @property-read \App\ManagedFile $managedFile
 * @mixin \Eloquent
 */
class Page extends Model
{
    use SoftDeletes;

    protected $table = 'comic_pages';

    public function comic()
    {
        return $this->belongsTo('App\Comics\Comic');
    }

    public function thumbnail()
    {
        return $this->hasOne('App\Comics\Thumbnail');
    }

    public function managedFile()
    {
        return $this->belongsTo('App\ManagedFile');
    }
}