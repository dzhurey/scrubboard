<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agent;
use App\AgentGroup;
use App\Presenters\AgentPresenter;
use App\Http\Requests\StoreAgent;
use App\Services\Agent\AgentStoreService;

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
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
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
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $data = [
            'agent' => $presenter->transform($agent),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
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
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'agents.index', 'data' => []], 201);
    }

    public function edit(Agent $agent)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $data = [
            'agent' => $agent,
            'agent_groups' => AgentGroup::orderBy('id', 'ASC')->pluck('name', 'id')
        ];
        return view('agent.edit', $data);
    }

    public function update(
        StoreAgent $request,
        Agent $agent,
        AgentStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $agent);
        return $this->renderView($request, '', [], ['route' => 'agents.edit', 'data' => ['agent' => $agent->id]], 204);
    }

    public function destroy(Request $request, Agent $agent)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $agent->delete();
        return $this->renderView($request, '', [], ['route' => 'agents.index', 'data' => []], 204);
    }
}
