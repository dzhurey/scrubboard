<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 *
 */
trait ResponseTrait
{
    public function renderView(
        Request $request,
        String $template,
        Array $data = []
    ) {
        if ($request->format() == 'html' && !empty($template)) {
            return view($template, $data);
        } elseif ($request->format() == 'json') {
            return response()
                    ->json($data);
        }

        return response('Your request is not allowed', 400);
    }
}
