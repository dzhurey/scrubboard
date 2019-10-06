<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agent;
use App\AgentGroup;
use App\Presenters\AgentPresenter;
use App\Http\Requests\StoreAgent;
use App\Http\Requests\StoreUpdateAgent;
use App\Services\Agent\AgentStoreService;
use App\Services\Agent\AgentUpdateService;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        AgentPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'agents' => $results->getCollection(),
        ];
        return $this->renderView($request, 'agent.index', $data, [], 200);
    }

    public function show(
        Request $request,
        Agent $agent,
        AgentPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'agent' => $presenter->transform($agent),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'agent_groups' => AgentGroup::orderBy('id', 'ASC')->pluck('name', 'id')
        ];
        return view('agent.create', $data);
    }

    public function store(
        StoreAgent $request,
        AgentStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'agents.index', 'data' => []], 201);
    }

    public function edit(Request $request, Agent $agent)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'agent' => $agent,
            'agent_groups' => AgentGroup::orderBy('id', 'ASC')->pluck('name', 'id')
        ];
        return view('agent.edit', $data);
    }

    public function update(
        StoreUpdateAgent $request,
        Agent $agent,
        AgentUpdateService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $agent);
        return $this->renderView($request, '', [], ['route' => 'agents.edit', 'data' => ['agent' => $agent->id]], 204);
    }

    public function destroy(Request $request, Agent $agent)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!empty($agent->transactions)) {
            return $this->renderError($request, __("rules.cannot_delete_agent_has_transaction"), 422);
        }

        $agent->delete();
        return $this->renderView($request, '', [], ['route' => 'agents.index', 'data' => []], 204);
    }
}
