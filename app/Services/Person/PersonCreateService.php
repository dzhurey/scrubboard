<?php

namespace App\Services\Person;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Person;
use App\User;

class PersonCreateService extends BaseService
{
    protected $attributes;
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
        DB::beginTransaction();
        try {
            $this->user = $this->assignAttributes($this->user, $attributes);
            $this->user->save();

            if (!empty($this->user->id)) {
                $attributes['user_id'] = $this->user->id;
                $this->person = $this->assignAttributes($this->person, $attributes);
                $this->person->save();
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
}
