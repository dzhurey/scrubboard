<?php

namespace Lib\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    public function assignAttributes(Model $model, Array $attributes)
    {
        $fillable = $model->getFillable();
        foreach ($fillable as $field) {
            $model->{$field} = $attributes[$field];
        }
        return $model;
    }
}