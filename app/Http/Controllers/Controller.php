<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\ResponseTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ResponseTrait;

    public function allowUser($permission)
    {
        return Gate::allows($permission, auth()->user());
    }

    public function allowAny($permissions)
    {
        return Gate::any($permissions, auth()->user());
    }
}
