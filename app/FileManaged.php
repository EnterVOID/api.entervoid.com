<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FileManaged
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
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereMime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereOriginalFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereAttacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereAttacherType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileManaged whereDeletedAt($value)
 * @mixin \Eloquent
 */
class FileManaged extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files_managed';

    /**
     * Get all of the owning "attach" models.
     */
    public function attacher()
    {
        return $this->morphTo();
    }

}
