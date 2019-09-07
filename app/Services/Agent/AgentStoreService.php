<?php

namespace App\Services\Agent;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Agent;
use App\AgentGroup;
use Carbon\Carbon;

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
        if (is_null($this->model->agent_code)) {
            $today = Carbon::now(8);
            $year = $today->year;
            $agent = Agent::where('agent_group_id',$attributes['agent_group_id'])
                ->whereYear('created_at',$year)
                ->orderBy('created_at','desc')
                ->first();
            $agent_group_code = AgentGroup::where('id',$attributes['agent_group_id'])->first();
            
            if (is_null($agent)) {
                $attributes['agent_code'] = $agent_group_code->agent_group_code.substr($year,-2).'000001';
            } else {
                $last_number = (int)substr($agent->agent_code,1);
                $next_number = $last_number+1;
                $attributes['agent_code'] = $agent_group_code->agent_group_code.$next_number;
            }
        }
        else {
            $attributes['agent_code'] = $this->model->agent_code;
        }
        
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }
}
