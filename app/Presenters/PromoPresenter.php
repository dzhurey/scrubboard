<?php

namespace App\Presenters;

use Lib\Presenters\PresenterInterface;
use Lib\Presenters\BasePresenter;
use App\Promo;

class PromoPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Promo $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->promo = $input->promo;
        return $input;
    }
}
