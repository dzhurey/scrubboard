<?php

namespace Lib\Presenters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;

abstract class BasePresenter
{
    protected $validated;
    protected $collection;
    protected $single;
    protected $builder;

    public function getCollection()
    {
        return Datatables::of($this->collection)->make(true);
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
            'filter' => 'array'
        ]);

        // $this->collection = $this->search($this->validated)->paginate(Config::get('constants.default_per_page'));
        // $this->collection->getCollection()->transform(function($single, $key) {
        //     return $this->transform($single);
        // });
        $this->collection = $this->search($this->validated)->get();

        $this->collection->transform(function($single, $key) {
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

        if (isset($attributes['filter'])) {
            $filters = array_map(function($item) {
                return explode(',', $item);
            }, $attributes['filter']);

            $validated = $this->validateFilter($filters);

            if (!empty($validated['custom_filters'])) {
                $this->builder = $this->model->customFilter($this->builder, $validated['custom_filters']);
            }
            $this->builder = $this->builder->where($validated['normal_filters']);
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

    private function validateFilter($filters)
    {
        $filterable = $this->model->getFilterable();
        $custom_filterable = $this->model->getCustomFilterable();
        $normal_filters = [];
        $custom_filters = [];

        foreach ($filters as $value) {
            if (in_array($value[0], $filterable)) {
                array_push($normal_filters, $value);
            } else if (in_array($value[0], $custom_filterable)) {
                array_push($custom_filters, $value);
            } else {
                throw new \App\Exceptions\UnprocessableEntityException('cannot filter with '.$value[0].' attributes', 1);
            }
        }

        return [
            'normal_filters' => $normal_filters,
            'custom_filters' => $custom_filters
        ];
    }
}
