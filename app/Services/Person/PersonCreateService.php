<?php

namespace App\Services\Person;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Lib\Services\BaseService;
use App\Person;
use App\User;

class PersonCreateService extends BaseService
{
    protected $user;
    protected $person;

    public function __construct(
        User $user,
        Person $person
    ) {
      $this->user = $user;
      $this->person = $person;
    }

    public function perform(Array $attributes)
    {
        dd($attributes);
        DB::beginTransaction();
        try {
            $this->createUser($attributes);

            if (!empty($this->user->id)) {
                $this->createPerson($attributes);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPerson()
    {
        return $this->person;
    }

    private function createUser($attributes)
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $this->user = $this->assignAttributes($this->user, $attributes);
        $this->user->save();
    }

    private function createPerson($attributes)
    {
        $attributes['user_id'] = $this->user->id;
        $this->person = $this->assignAttributes($this->person, $attributes);
        $this->person->save();
    }
}
