<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemGroup;
use App\Http\Requests\StoreItemGroup;
use App\Services\ItemGroup\ItemGroupStoreService;

class ItemGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $item_groups = ItemGroup::orderBy('id', 'DESC')->get();
        return view('item_group.index', ['item_groups' => $item_groups]);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('item_group.create');
    }

    public function store(
        StoreItemGroup $request,
        ItemGroupStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);
        return redirect()->route('item_groups.index');
    }

    public function edit(ItemGroup $item_group)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('item_group.edit', ['item_group' => $item_group]);
    }

    public function update(
        StoreItemGroup $request,
        ItemGroup $item_group,
        ItemGroupStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $item_group);
        return redirect()->route('item_groups.edit', ['item_group' => $item_group->id]);
    }

    public function destroy(ItemGroup $item_group)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $item_group->delete();
        return redirect()->route('item_groups.index');
    }
}