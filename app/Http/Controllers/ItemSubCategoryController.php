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
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'item_sub_categories' => $results->getCollection(),
        ];
        return $this->renderView($request, 'item_sub_category.index', $data, [], 200);
    }

    public function show(
        Request $request,
        ItemSubCategory $item_sub_category,
        ItemSubCategoryPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'item_sub_category' => $presenter->transform($item_sub_category),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $item_groups = ItemGroup::orderBy('id', 'ASC')->pluck('name', 'id');
        return view('item_sub_category.create', ['item_groups' => $item_groups]);
    }

    public function store(
        StoreItemSubCategory $request,
        ItemSubCategoryStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'item_sub_categories.index', 'data' => []], 201);
    }

    public function edit(Request $request, ItemSubCategory $item_sub_category)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
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
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $item_sub_category);
        return $this->renderView($request, '', [], ['route' => 'item_sub_categories.edit', 'data' => ['item_sub_category' => $item_sub_category->id]], 204);
    }

    public function destroy(Request $request, ItemSubCategory $item_sub_category)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (count($item_sub_category->items) > 0) {
            return $this->renderError($request, __("rules.cannot_delete_sub_category_has_item"), 422);
        }

        $item_sub_category->delete();
        return $this->renderView($request, '', [], ['route' => 'item_sub_categories.index', 'data' => []], 204);
    }
}
