<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Presenters\PersonPresenter;
use App\Http\Requests\StoreCourier;
use App\Services\Person\PersonCreateService;
use App\Services\Person\PersonUpdateService;

class CourierController extends Controller
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
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $couriers = Person::whereHas('user', function ($query) {
            $query->where('role', '=', 'courier');
        });

        $results = $presenter->setBuilder($couriers)->performCollection($request);

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
    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
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
        StoreCourier $request,
        PersonCreateService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }
        $validated = $request->validated();
        $validated['role'] = 'courier';
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
        if (!$this->allowUser('superadmin-only')) {
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
    public function edit(Person $person)
    {
        if (!$this->allowUser('superadmin-only')) {
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
        StoreCourier $request,
        Person $person,
        PersonUpdateService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $validated['role'] = $person->user->role;
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
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $person->user->delete();
        return $this->renderView($request, '', [], ['route' => 'people.index', 'data' => []], 204);
    }
}
