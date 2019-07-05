<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Person;
use App\Http\Requests\StorePerson;

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
    public function index()
    {
        $people = Person::all();
        return view('person.index', ['people' => $people]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('person.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerson $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $user = new User;
            $user->email = $validated['email'];
            $user->password = $validated['password'];
            $user->save();

            $person = new Person;
            $person->user_id = $user;
            $person->name = $validated['name'];
            $person->birth_date = $validated['birth_date'];
            $person->gender = $validated['gender'];
            $person->religion = $validated['religion'];
            $person->phone_number = $validated['phone_number'];
            $person->address = $validated['address'];
            $person->district = $validated['district'];
            $person->city = $validated['city'];
            $person->country = $validated['country'];
            $person->zip_code = $validated['zip_code'];
            $person->role = $validated['role'];
            $person->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->with('error',$th->getMessage());
        }
        DB::commit();

        return redirect()->route('people_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
