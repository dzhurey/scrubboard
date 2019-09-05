<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Brand;

class BrandPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        return $input;
    }
}
