<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\ItemSubCategory;
use App\ItemGroup;
use App\Presenters\ItemSubCategoryPresenter;
use App\Http\Requests\StoreItemSubCategory;
use App\Services\ItemSubCategory\ItemSubCategoryStoreService;

use Illuminate\Database\Eloquent\Builder;

class ItemSubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        ItemSubCategoryPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'item_sub_categories' => $results->getCollection(),
        ];
        return view('item_sub_category.index', $data);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $item_groups = ItemGroup::orderBy('id', 'ASC')->pluck('name', 'id');
        return view('item_sub_category.create', ['item_groups' => $item_groups]);
    }

    public function store(
        StoreItemSubCategory $request,
        ItemSubCategoryStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);
        return redirect()->route('item_sub_categories.index');
    }

    public function edit(ItemSubCategory $item_sub_category)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $item_groups = ItemGroup::orderBy('id', 'ASC')->pluck('name', 'id');
        $data = [
            'item_sub_category' => $item_sub_category,
            'item_groups' => $item_groups,
        ];
        return view('item_sub_category.edit', $data);
    }

    public function update(
        StoreItemSubCategory $request,
        ItemSubCategory $item_sub_category,
        ItemSubCategoryStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $item_sub_category);
        return redirect()->route('item_sub_categories.edit', ['item_sub_category' => $item_sub_category->id]);
    }

    public function destroy(ItemSubCategory $item_sub_category)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $item_sub_category->delete();
        return redirect()->route('item_sub_categories.index');
    }
}
