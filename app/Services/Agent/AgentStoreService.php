<?php

namespace App\Services\Agent;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Agent;

class AgentStoreService extends BaseService
{
    protected $model;

    public function __construct(
        Agent $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, Agent $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createAgent($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createAgent($attributes)
    {
        $a = "A1900000001" + 1;
        dd($attributes,$a);
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }
}
