<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Agent;

class AgentPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Agent $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->agent_group = $input->agentGroup;
        return $input;
    }
}
