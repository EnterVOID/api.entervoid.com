<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     * Get all of the owning "attach" models.
     */
    public function attacher()
    {
        return $this->morphTo();
    }

}
