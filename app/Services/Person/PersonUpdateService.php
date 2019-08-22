<?php

namespace App\Services\Person;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Lib\Services\BaseService;
use App\Person;

class PersonUpdateService extends BaseService
{
    protected $person;
    protected $user;

    public function perform(Person $person, Array $attributes)
    {
        $this->person = $person;
        $this->user = $person->user;
        DB::beginTransaction();
        try {
            $this->saveUser($attributes);
            $this->savePerson($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function getPerson()
    {
        return $this->person;
    }

    private function saveUser($attributes)
    {
        $excluded = ['email', 'password'];
        $this->user = $this->assignAttributes($this->user, $attributes, $excluded);
        $this->user->save();
    }

    private function savePerson($attributes)
    {
        $excluded = ['user_id'];
        $this->person = $this->assignAttributes($this->person, $attributes, $excluded);
        $this->person->save();
    }
}
