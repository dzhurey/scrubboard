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
        Array $data = [],
        Array $redirect_to = [],
        $response_code = null
    ) {
        if ($request->format() == 'html') {
            if (!empty($template)) {
                return view($template, $data);
            } elseif (!empty($redirect_to)) {
                return redirect()->route($redirect_to['route'], $redirect_to['data']);
            }
        } elseif ($request->format() == 'json') {
            return response()
                    ->json($data, $response_code);
        }

        return response('Your request is not allowed', 400);
    }
}
