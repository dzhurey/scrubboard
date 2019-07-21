<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\ItemGroup;
use App\ItemSubCategory;
use App\Presenters\ItemPresenter;
use App\Http\Requests\StoreItem;
use App\Services\Item\ItemStoreService;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        ItemPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'items' => $results->getCollection(),
        ];
        return view('item.index', $data);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $item_groups = ItemGroup::orderBy('id', 'ASC')->pluck('name', 'id');
        $item_sub_categories = ItemSubCategory::orderBy('id', 'ASC')->pluck('name', 'id');
        $data = [
            'item_groups' => $item_groups,
            'item_sub_categories' => $item_sub_categories,
        ];
        return view('item.create', $data);
    }

    public function store(
        StoreItem $request,
        ItemStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);
        return redirect()->route('items.index');
    }

    public function edit(Item $item)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $item_groups = ItemGroup::orderBy('id', 'ASC')->pluck('name', 'id');
        $item_sub_categories = ItemSubCategory::orderBy('id', 'ASC')->pluck('name', 'id');
        $data = [
            'item_groups' => $item_groups,
            'item_sub_categories' => $item_sub_categories,
            'item' => $item,
        ];
        return view('item.edit', $data);
    }

    public function update(
        StoreItem $request,
        Item $item,
        ItemStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $item);
        return redirect()->route('items.edit', ['item' => $item->id]);
    }

    public function destroy(Item $item)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $item->delete();
        return redirect()->route('items.index');
    }
}
