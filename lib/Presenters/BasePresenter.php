<?php

namespace Lib\Presenters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;

abstract class BasePresenter
{
    protected $validated;
    protected $collection;
    protected $single;
    protected $builder;

    public function getCollection()
    {
        return $this->collection;
    }

    public function getSingle()
    {
        return $this->single;
    }

    public function getValidated()
    {
        return $this->validated;
    }

    public function performCollection(Request $request)
    {
        $this->validated = $request->validate([
            'q' => 'string',
            'page' => 'numeric',
        ]);

        $this->collection = $this->search($this->validated)->paginate(Config::get('constants.default_per_page'));
        $this->collection->getCollection()->transform(function($single, $key) {
            return $this->transform($single);
        });

        return $this;
    }

    public function search($attributes)
    {
        $searchable = $this->model->getSearchable();
        if (!isset($this->builder)) {
            $this->builder = $this->model;
        }

        if(!empty($attributes['q']) && !empty($searchable)) {
            foreach ($searchable as $field) {
                $sanitized = trim($attributes['q']);
                $exploded_field = explode('__', $field);
                if (count($exploded_field) > 1) {
                    $this->builder = $this->model->orWhereHas($exploded_field[0], function (Builder $query) use ($exploded_field, $sanitized) {
                        $query->where($exploded_field[1], 'ILIKE', "%".$sanitized."%");
                    });
                } else {
                    $this->builder = $this->model->orWhere($field,'ILIKE',"%".$sanitized."%");
                }
            }
        }

        return $this->builder;
    }

    public function filter($parameters) {
        $this->model = $this->model->where($parameters);
        return $this;
    }

    public function setBuilder($builder) {
        $this->builder = $builder;
        return $this;
    }
}
