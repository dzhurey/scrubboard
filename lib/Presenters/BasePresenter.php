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

        return $this;
    }

    public function search($attributes)
    {
        $searchable = $this->model->getSearchable();

        if(!empty($attributes['q']) && !empty($searchable)) {
            foreach ($searchable as $field) {
                $sanitized = trim($attributes['q']);
                $exploded_field = explode('__', $field);
                if (count($exploded_field) > 1) {
                    $this->model = $this->model->orWhereHas($exploded_field[0], function (Builder $query) use ($exploded_field, $sanitized) {
                        $query->where($exploded_field[1], 'LIKE', "%".strtoupper($sanitized)."%");
                    });
                } else {
                    $this->model = $this->model->orWhere($field,'LIKE',"%".$sanitized."%");
                }
            }
        }

        return $this->model;
    }
}