<?php

namespace App\Http\Controllers\Courier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CourierScheduleLine;
use App\DeliverySchedule;
use App\Presenters\CourierScheduleLinePresenter;
use App\Presenters\DeliverySchedulePresenter;
use App\Traits\CourierScheduleTrait;

class CourierDeliveryScheduleController extends Controller
{
    use CourierScheduleTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        DeliverySchedulePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $courier_schedules = DeliverySchedule::where('person_id', '=', $request->user()->id);

        $results = $presenter->setBuilder($courier_schedules)->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'delivery_schedules' => $results->getCollection(),
        ];

        return $this->renderView($request, 'courier_delivery_schedule.index', $data, [], 200);
    }

    public function show(
        Request $request,
        DeliverySchedule $delivery_schedule,
        DeliverySchedulePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'delivery_schedule' => $presenter->transform($delivery_schedule),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function edit(Request $request, CourierScheduleLine $courier_schedule_line)
    {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!$this->autorizedCourierScheduleLine($courier_schedule_line, $request, 'delivery')) {
            return $this->renderError($request, __("authorize.not_found"), 404);
        }

        return view('courier_delivery_schedule.edit', []);
    }

    /**
     * Request method POST
     *
     * use multipart/formdata
     * form attributes:
     *  image: "image_uploaded.jpg/png"
     *  _method: "put"
     */
    public function update(
        Request $request,
        CourierScheduleLine $courier_schedule_line
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!$this->autorizedCourierScheduleLine($courier_schedule_line, $request, 'delivery')) {
            return $this->renderError($request, __("authorize.not_found"), 404);
        }

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $uploadedFile = $request->file('image');
        $path = $uploadedFile->store('public/uploads');
        $courier_schedule_line->image_name = $path;
        $courier_schedule_line->save();
        $courier_schedule_line->transactionLine->status = 'done';
        $courier_schedule_line->transactionLine->save();

        return $this->renderView($request, '', [], ['route' => 'courier.delivery_schedules.edit', 'data' => ['courier_schedule_line' => $courier_schedule_line->id]], 204);
    }
}
