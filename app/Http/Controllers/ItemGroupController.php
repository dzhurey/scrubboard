<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemGroup;
use App\Presenters\ItemGroupPresenter;
use App\Http\Requests\StoreItemGroup;
use App\Services\ItemGroup\ItemGroupStoreService;

class ItemGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        ItemGroupPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'item_groups' => $results->getCollection(),
        ];
        return $this->renderView($request, 'item_group.index', $data, [], 200);
    }

    public function show(
        Request $request,
        ItemGroup $item_group,
        ItemGroupPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'item_group' => $presenter->transform($item_group),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('item_group.create');
    }

    public function store(
        StoreItemGroup $request,
        ItemGroupStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'item_groups.index', 'data' => []], 201);
    }

    public function edit(ItemGroup $item_group)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('item_group.edit', ['item_group' => $item_group]);
    }

    public function update(
        StoreItemGroup $request,
        ItemGroup $item_group,
        ItemGroupStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $item_group);
        return $this->renderView($request, '', [], ['route' => 'item_groups.edit', 'data' => ['item_group' => $item_group->id]], 204);
    }

    public function destroy(Request $request, ItemGroup $item_group)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $item_group->delete();
        return $this->renderView($request, '', [], ['route' => 'item_groups.index', 'data' => []], 204);
    }
}
