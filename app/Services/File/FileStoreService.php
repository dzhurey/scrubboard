<?php

namespace App\Services\File;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\File;
use App\CourierScheduleLine;

class FileStoreService extends BaseService
{
    protected $model;
    protected $courier_schedule_line;

    public function __construct(
        File $model
    ) {
      $this->model = $model;
    }

    public function perform($uploadedFile, CourierScheduleLine $courier_schedule_line)
    {
        $this->courier_schedule_line = $courier_schedule_line;
        DB::beginTransaction();
        try {
            $path = $uploadedFile->store('public/uploads');
            $file = $this->model;
            $file->name = $path;
            $file->courier_schedule_line_id = $courier_schedule_line->id;
            $file->save();
            $courier_schedule_line->transactionLine->status = 'done';
            $courier_schedule_line->transactionLine->save();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }
}
