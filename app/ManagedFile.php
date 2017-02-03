<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * App\ManagedFile
 *
 * @property integer $id
 * @property string $filename
 * @property string $mime
 * @property string $original_filename
 * @property integer $attacher_id
 * @property string $attacher_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $attacher
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereMime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereOriginalFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereAttacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereAttacherType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ManagedFile whereDeletedAt($value)
 * @mixin \Eloquent
 */
class ManagedFile extends Model
{
    /**
     * Save a new model and return the instance.
     *
     * @param UploadedFile $file
     * @param null $path
     * @return static
     */
    public static function createFromFile(UploadedFile $file, $path = null)
    {
        $path = $path ?? 'uploads/';
        $filename = $file->getFilename() . '.' . $file->getClientOriginalExtension();
        $destination = $path . $filename;
        Storage::disk('local')->put($destination, File::get($file));
        // Add managed file to database using ManagedFile model
        $model = new static;
        $model->mime = $file->getClientMimeType();
        $model->original_filename = $file->getClientOriginalName();
        $model->filename = $filename;
        $model->path = $path;

        $model->save();

        return $model;
    }

    public function getFile()
    {
        return Storage::disk('local')->get($this->path . $this->filename);
    }

}
