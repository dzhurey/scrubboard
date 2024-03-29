<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Presenters\PersonPresenter;
use App\Http\Requests\StorePerson;
use App\Services\Person\PersonCreateService;
use App\Services\Person\PersonUpdateService;

class PersonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        PersonPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'operation'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'people' => $results->getCollection(),
        ];
        return $this->renderView($request, 'person.index', $data, [], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('person.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StorePerson $request,
        PersonCreateService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'people.index', 'data' => []], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        Person $person,
        PersonPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'operation'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'person' => $presenter->transform($person),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Person $person)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('person.edit', ['person' => $person]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(
        StorePerson $request,
        Person $person,
        PersonUpdateService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($person, $validated);
        return $this->renderView($request, '', [], ['route' => 'people.edit', 'data' => ['person' => $person->id]], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Person $person)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if ($person->user->isCourier() && count($person->courierSchedules) > 0) {
            return $this->renderError($request, __("rules.cannot_delete_courier_has_schedule"), 422);
        }

        $person->user->delete();
        return $this->renderView($request, '', [], ['route' => 'people.index', 'data' => []], 204);
    }
}
