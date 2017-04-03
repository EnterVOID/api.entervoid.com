<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SluggableModel extends Model
{
    protected $sluggableAttribute;

    public function getSluggableAttribute()
    {
        return $this->getAttribute($this->sluggableAttribute);
    }

    protected static function boot()
    {
        parent::boot();

        // Auto timestamp requests.
        SluggableModel::saving(function (SluggableModel $model) {
            if (empty($model->slug)) {
                $model->slug = str_slug($model->getSluggableAttribute());
            }

            return $model;
        });
    }
}
