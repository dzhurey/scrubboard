<?php

namespace App\Http\Controllers\Courier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CourierScheduleLine;
use App\PickupSchedule;
use App\SalesOrder;
use App\Presenters\CourierScheduleLinePresenter;
use App\Presenters\PickupSchedulePresenter;
use App\Traits\CourierScheduleTrait;
use App\Services\File\FileStoreService;

class CourierPickupScheduleController extends Controller
{
    use CourierScheduleTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        PickupSchedulePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $courier_schedules = PickupSchedule::where('person_id', '=', $request->user()->id);

        $results = $presenter->setBuilder($courier_schedules)->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'pickup_schedules' => $results->getCollection(),
        ];
        return $this->renderView($request, 'courier_pickup_schedule.index', $data, [], 200);
    }

    public function show(
        Request $request,
        PickupSchedule $pickup_schedule,
        PickupSchedulePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'pickup_schedule' => $presenter->transform($pickup_schedule),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function edit(Request $request, PickupSchedule $pickup_schedule)
    {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!$this->autorizedCourierSchedule($pickup_schedule, $request, 'pickup')) {
            return $this->renderError($request, __("authorize.not_found"), 404);
        }

        return view('courier_pickup_schedule.edit', []);
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
        CourierScheduleLine $courier_schedule_line,
        FileStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!$this->autorizedCourierScheduleLine($courier_schedule_line, $request, 'pickup')) {
            return $this->renderError($request, __("authorize.not_found"), 404);
        }

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $uploadedFile = $request->file('image');
        $service->perform($uploadedFile, $courier_schedule_line);

        return $this->renderView($request, '', [], ['route' => 'courier.pickup_schedules.edit', 'data' => ['courier_schedule_line' => $courier_schedule_line->id]], 204);
    }
}
