<?php

namespace Lib\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    public function assignAttributes(Model $model, Array $attributes, Array $excluded=[])
    {
        $fillable = $model->getFillable();
        $fillable = array_diff($fillable, $excluded);
        foreach ($fillable as $field) {
            $model->{$field} = $attributes[$field];
        }
        return $model;
    }
}