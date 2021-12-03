<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class ExportSalesOrder extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * input json
     * {
     *      "date_from": "2019-08-20",
     *      "date_to": "2019-08-21"
     *  }
     */
    public function rules()
    {
        return [
            'date_from' => 'required|date_format:"Y-m-d"',
            'date_to' => 'required|date_format:"Y-m-d"'
        ];
    }
}
