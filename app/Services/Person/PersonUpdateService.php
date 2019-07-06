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

    public function perform(Person $person, Array $attributes)
    {
        $this->person = $person;
        DB::beginTransaction();
        try {
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

    private function savePerson($attributes)
    {
        $excluded = ['user_id'];
        $this->person = $this->assignAttributes($this->person, $attributes, $excluded);
        $this->person->save();
    }
}
