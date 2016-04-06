<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
