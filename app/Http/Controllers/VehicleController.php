<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;

class VehicleController extends Controller
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

        $vehicles = Vehicle::all();
        return view('vehicle.index', ['vehicles' => $vehicles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('vehicle.create');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(
    //     StorePerson $request,
    //     PersonCreateService $service
    // ) {
    //     if (!$this->allowUser('superadmin-only')) {
    //         return back()->with('error', __("authorize.not_superadmin"));
    //     }

    //     $validated = $request->validated();
    //     $service->perform($validated);
    //     return redirect()->route('people.index');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Person  $person
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Vehicle $vehicle)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Person  $person
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Vehicle $vehicle)
    // {
    //     if (!$this->allowUser('superadmin-only')) {
    //         return back()->with('error', __("authorize.not_superadmin"));
    //     }

    //     return view('vehicle.edit', ['person' => $person]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Person  $person
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(
    //     StorePerson $request,
    //     Vehicle $vehicle,
    //     PersonUpdateService $service
    // ) {
    //     if (!$this->allowUser('superadmin-only')) {
    //         return back()->with('error', __("authorize.not_superadmin"));
    //     }

    //     $validated = $request->validated();
    //     $service->perform($person, $validated);
    //     return redirect()->route('people.edit', ['person' => $person->id]);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Person  $person
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Vehicle $vehicle)
    // {
    //     if (!$this->allowUser('superadmin-only')) {
    //         return back()->with('error', __("authorize.not_superadmin"));
    //     }

    //     $person->user->delete();
    //     return redirect()->route('people.index');
    // }
}
